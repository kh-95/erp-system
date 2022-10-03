<?php

namespace App\Modules\HR\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {  
        return [
            'image' => 'sometimes|image|mimes:jpg,png,jpeg|max:3000',
            'identification_number' => 'required|digits:10|numeric|unique:hr_employees',
            'first_name' => 'required',
            'second_name' => 'required',
            'third_name' => 'required',
            'last_name' => 'required',
            'identity_source' => 'required',
            'employee_number' => 'required|unique:hr_employee_job_information',
            'identity_date' => 'required|date',
            'nationality_id' => 'required',
            'phone' => 'required|unique:hr_employees|digits:10',
            'date_of_birth' => 'required',
            'address' => 'required|max:120',
            'email' => 'required|email|max:100|unique:hr_employees',
            'marital_status' => 'required|in:single,married,separated,widowed',
            'gender' => 'required|in:male,female',
            'qualification' => 'required',
            // 'attachments' => 'required|array',
            // 'attachments.*' => 'image|mimes:jpg,png,jpeg|required|max:3000',
            // 'attachments.identity_photo' => 'required',
            // 'attachments.qualification_photo' => 'required',
            // 'job_id' => 'required|int',
            // 'receiving_work_date' => 'required',
            // 'contract_period' => 'required|int',
            // 'contract_type' => 'required|in:salary,percent,both',
            // 'salary' => 'required_if:contract_type,==,salary|required_if:contract_type,==,both',
            // 'salary_percentage' => 'required_if:contract_type,==,percent|required_if:contract_type,==,both',
            'company' => 'required|in:rasidholding,tasahel,rasid,fintech',
            // 'allowances' => 'required|array',
            // 'allowances.*.allowance_id' => 'required',
            // 'allowances.*.status' => 'required',
            // 'allowances.*.value' => 'required_if:allowances.*.status,==,1',
            // 'custodies' => 'sometimes|array',
            // 'custodies.*.type' => 'required',
            // 'custodies.*.count' => 'sometimes|int',
            // 'custodies.*.received_date' => 'required|date',
            // 'custodies.*.delivery_date' => 'sometimes|date',
        ]; 
    }

    protected function failedValidation(Validator $validator)
    { 
        throw (new ValidationException($validator, response(['error' => $validator->errors()->first()])));
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
            'image.required' => trans('hr::validations.employees.required_image'),
            'image.max' => trans('hr::validations.employees.max_size_image'),
            'image.mimes' => trans('hr::validations.employees.mimes_image'),
            'identification_number.required' => trans('hr::validations.employees.required_identification_number'),
            'identification_number.max' => trans('hr::validations.employees.max_identification_number'),
            'identification_number.unique' => trans('hr::validations.employees.unique_identification_number'),
            'first_name.required' => trans('hr::validations.employees.required_first_name'),
            'second_name.required' => trans('hr::validations.employees.required_second_name'),
            'third_name.required' => trans('hr::validations.employees.required_third_name'),
            'last_name.required' => trans('hr::validations.employees.required_last_name'),
            'identity_source.required' => trans('hr::validations.employees.required_identity_source'),
            'phone.unique' => trans('hr::validations.employees.unique_phone'),
            'phone.required' => trans('hr::validations.employees.required_phone'),
            'nationality_id.required' => trans('hr::validations.employees.required_nationality'),
            'identity_date.required' => trans('hr::validations.employees.required_identity_date'),
            'date_of_birth.required' => trans('hr::validations.employees.required_date_of_birth'),
            'address.max' => trans('hr::validations.employees.max_address'),
            'email.required' => trans('hr::validations.employees.required_email'),
            'email.unique' => trans('hr::validations.employees.unique_email'),
            'marital_status.required' => trans('hr::validations.employees.required_marital_status'),
            'gender.required' => trans('hr::validations.employees.required_gender'),
            'qualification.required' => trans('hr::validations.employees.required_qualification'),
            'attachments.identity_photo.required' => trans('hr::validations.employees.required_attachments'),
            'attachments.qualification_photo.required' => trans('hr::validations.employees.required_attachments'),
            'attachments.required' => trans('hr::validations.employees.required_attachments'),
            'job_id.required' => trans('hr::validations.employees.required_job_id'),
            'contract_type.required' => trans('hr::validations.employees.required_contract_type'),
            'salary.required' => trans('hr::validations.employees.required_salary'),
            'salary_percentage.required' => trans('hr::validations.employees.required_salary_percentage'),
            'receiving_work_date.required' => trans('hr::validations.employees.required_receiving_work_date'),
            'contract_period.required' => trans('hr::validations.employees.required_contract_period'),
        ];
    }
}
