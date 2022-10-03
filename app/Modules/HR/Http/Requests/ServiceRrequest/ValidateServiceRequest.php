<?php

namespace App\Modules\HR\Http\Requests\ServiceRrequest;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use Astrotomic\Translatable\Validation\RuleFactory;

class ValidateServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $managementTable = Management::getTableName();
        $employeeTable = Employee::getTableName();
        $rules = RuleFactory::make([
            'management_id' =>"required|exists:{$managementTable},id",
            'employee_id' =>"required|exists:{$employeeTable},id",
            'service_type' => 'required|regex:/(^[a-zA-Z0-9_ ]+$)+/',
            'directed_to' => 'required|regex:/(^[a-zA-Z0-9_ ]+$)+/',
            '%notes%' => 'required|regex:/(^[a-zA-Z0-9_ ]+$)+/|between:10,5000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf,wma,wmv,mp3|max:100000'
        ]);
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

    public function messages()
    {
        return [
            'management_id.required' => __('hr::validation.service.management.requierd'),
            'management_id.exists' => __('hr::validation.service.management.exists'),
            'employee_id.required' => __('hr::validation.service.employee.requierd'),
            'employee_id.exists' => __('hr::validation.service.employee.exists'),
            'service_type.required' => __('hr::validation.service.service_type.required'),
            'directed_to.required' => __('hr::validation.service.directed_to.required'),
            'ar.notes.required' => __('hr::validation.service.notes.required'),
            'attachments.array' => __('hr::validation.service.attachments.array'),

        ];

    }
}
