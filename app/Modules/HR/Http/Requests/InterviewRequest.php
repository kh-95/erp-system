<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\BlackList;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Job;
use Illuminate\Foundation\Http\FormRequest;

class InterviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $job_table = Job::getTableName();
        $employee_table = Employee::getTableName();
        $item_table = Item::getTableName();
        $interview_applications_table = InterviewApplication::getTableName();

        return [
            'job_id' => "required|exists:$job_table,id",
            'members.*' => "required|exists:$employee_table,id",
            'applications.*.id' => "required_if:_method,put|exists:$interview_applications_table,id",

            'applications.*.email' => "required|email",
            'applications.*.identity_number' => ['required', 'digits:10', 'numeric',
                function ($attribute, $value, $fail) {
                    $score = BlackList::where('identity_number', $value)->first();
                    if ($score) {
                        $fail('The ' . $attribute . ' in black list');
                    }
                }],
            'applications.*.name' => "required|regex:/(^[a-zA-Z0-9_ ]+$)+/",
            'applications.*.interview_date' => "required|date",
            'applications.*.mobile' => ['required', 'digits:10', 'numeric',
                function ($attribute, $value, $fail) {
                    $score = BlackList::where('phone', $value)->first();
                    if ($score) {
                        $fail('The ' . $attribute . ' in black list');
                    }
                }],
            'applications.*.note' => "nullable|regex:/(^[a-zA-Z0-9_ ]+$)+/|between:10,5000",
            'applications.*.recommended' => "required|in:0,1",
            'applications.*.items.*.item_id' => ["required", "exists:$item_table,id"
                //TODO: validation score
//                , function ($attribute, $value, $fail) {
//                $score = Item::find($value)->score;
//                if ($score > 1000) {
//                    $fail('The ' . $attribute . ' is invalid.');
//                }}
            ],
            'applications.*.items.*.score' => "required|regex:/^\d{2}(\.\d{2})?$/"
        ];
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
