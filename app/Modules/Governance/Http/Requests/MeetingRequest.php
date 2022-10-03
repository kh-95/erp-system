<?php

namespace App\Modules\Governance\Http\Requests;

use App\Modules\Governance\Entities\Meeting;
use App\Modules\Governance\Entities\MeetingPlace;
use App\Modules\Governance\Http\Repositories\Meeting\EmployeeDoesntHaveMeetings;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
{
    use PublicMeetingRequest, EmployeeDoesntHaveMeetings;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $meetingPlacesTable = MeetingPlace::getTableName();
        $managementTable = Management::getTableName();
        $employeeTable = Employee::getTableName();
        $meetingTypes = join(',', Meeting::MEETING_TYPES);
        $meetingReplication = join(',', Meeting::MEETING_REPLICATION);
        // $minuteFormat = regex:/(^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1] (0[1-9]|1[0-2]):(00|30) (AM|PM))$)/


        $rules = [
            'subject' => 'required|regex:/(^.+$)+/|between:2,100',
            'meeting_place_id' => "nullable|exists:{$meetingPlacesTable},id",
            'meeting_types' => "required|in:{$meetingTypes}",
            'start_at' => ["required", function ($attribute, $value, $fail) {
                if (!$this->validateDateTime($value)) {
                    $fail('The ' . $attribute . ' is invalid format.');
                }
            },],
            'end_at' => ["required", "after_or_equal:start_at", function ($attribute, $value, $fail) {
                if (!$this->validateDateTime($value)) {
                    $fail('The ' . $attribute . ' is invalid format.');
                }
            }],
            'for_full_time' => ["nullable", "in:0,1"],
            'meeting_replication' => ["nullable", "in:{$meetingReplication}"],
            'notes' => "nullable|string|max:500",
            'points' => "required|array",
            'points.*' => "nullable|string|min:10,max:100",
            'attendances' => 'required|array',
            'attendances.*.management_id' => "required|exists:{$managementTable},id",
            'attendances.*.employee_id' => ["required", "exists:{$employeeTable},id", function ($attribute, $value, $fail) {
                if (!$this->checkEmployeeHasIntersectMeeting($value)) {
                    $fail('The ' . $attribute . ' has meeting in the same time');
                }
            }],
            'attendances.*.is_manager' => ["required", "in:0,1", function ($attribute, $value, $fail) {
                if (!$this->atLeastOneValuesIsManager($value)) {
                    $fail('The meeting must has only one manager');
                }

                if(!$this->checkIfManagerFound()){
                    $fail('The meeting must has manager');
                }
            }],
            'file_type' => 'required|in:' . implode(',', Meeting::ATTACHMENT_TYPES),

        ];

        if (request()->file_type == Meeting::VIDEO) {
            $rules['attachments.*'] = 'nullable|mimes:mp4,mov,wmv,avi,flv|max:100000';
        } elseif (request()->file_type == Meeting::DOCUMENT) {
            $rules['attachments.*'] = 'nullable|mimes:txt,doc,docx,pdf,xlsx,rar|max:100000';
        } else
            $rules['attachments.*'] = 'nullable|mimes:jpg,jpeg,png|max:100000';

        return $rules;
    }


    private function checkIfManagerFound()
    {
        $managers = array_column($this->attendances, 'is_manager');

        if (in_array(true, $managers)) {
            return true;
        }
        return false;
    }

    private function atLeastOneValuesIsManager($value)
    {
        $managers = array_column($this->attendances, 'is_manager');
        // dd(array_count_values($managers)[1]);
        if (array_count_values($managers)[1] > 1 && $value == true) {
            return false;
        }
        return true;
    }
    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'meeting_place_id' =>  $data['meeting_place_id'] == 'online' ? null : $data['meeting_place_id'],
        ]);
    }

    private function checkEmployeeHasIntersectMeeting($value)
    {
        $employee = Employee::where('id', $value)
            ->whereHas('job', function ($q) {
                $q->where('management_id', $this->management_id);
            })
            ->where(function ($q) {
                $q->wherehas('governanceMeetings', function ($q) {
                    $start_at = Carbon::parse($this->start_at)->toDateTimeString();
                    $end_at = Carbon::parse($this->end_at)->toDateTimeString();
                    $q->whereBetween('start_at', [$start_at, $end_at])->orWhereBetween('end_at', [$start_at, $end_at]);
                })->has('governanceMeetings');
            })
            ->first();
        if ($employee) {
            return false;
        }
        return true;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
