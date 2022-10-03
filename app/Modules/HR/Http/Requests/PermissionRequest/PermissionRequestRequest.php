<?php

namespace App\Modules\HR\Http\Requests\PermissionRequest;

use App\Modules\HR\Entities\PermissionRequest;
use App\Modules\HR\Entities\Vacation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\HR\Rules\PermissionRequests\{AppointmentCheckRule,
    AttendTimeRule,
    LeaveTimeRule,
    MeetingCheckRule,
    VacationCheckRule,
    CrossTimeRule
};

class PermissionRequestRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today',
                new VacationCheckRule
            ],
            'from' => ['required', 'date_format:H:i',
                new AttendTimeRule($this->from_duration),
            ],
            'to' => ['required', 'date_format:H:i',

                new LeaveTimeRule($this->from_duration, $this->date),
                new CrossTimeRule($this->date, $this->from, $this->from_duration, $this->to_duration),
                new MeetingCheckRule($this->date, $this->from, $this->from_duration, $this->to_duration),
                new AppointmentCheckRule($this->date, $this->from, $this->from_duration, $this->to_duration)

            ],
            'from_duration' => 'required|in:' . implode(',', PermissionRequest::DURATION),
            'to_duration' => 'required|in:' . implode(',', PermissionRequest::DURATION),
            'hr_notes' => 'nullable',
            'manager_notes' => 'nullable',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
