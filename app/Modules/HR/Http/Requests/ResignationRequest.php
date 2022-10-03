<?php

namespace App\Modules\HR\Http\Requests;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ResignationReason;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ResignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managementTable = Management::getTableName();
        $employeeTable = Employee::getTableName();

        $rules = [

            'management_id' => "required|exists:{$managementTable},id,deactivated_at,null",
             'employee_id' => "required|exists:hr_employees,id",
            'resignation_date' => 'sometimes|nullable|date_format:d-m-Y',
            'reasons' => "required|array",
            'reasons.*.resignation_id' => "",
            'attachments' => 'nullable|array|max:25000',
            'attachments.*'           => 'nullable|mimes:jpg,png,jpeg,pdf,docx,txt,video/avi,video/mpeg,mp3,mp4
            video/quicktime,zip|max:100000'

        ];

        $rules += RuleFactory::make([
             '%reasons.*%' => 'required|array',
             'reasons.*.reason' => "required|max:200",
            '%notes%' => "sometimes|nullable|max:500",
        ]);
        return $rules;
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        $langs = Config::get('translatable.locales');
        $messages = [
            'management_id.required' => __('hr::validation.resignation.management_id.required'),
            'employee_id.required' => __('hr::validation.resignation.employee_id.required'),
        ];
        foreach ($langs as $lang) {
            $messages += [
                $lang . '.reason.required' => __('hr::validation.resignation.reason.required')
            ];
        }
        return $messages;
    }
}
