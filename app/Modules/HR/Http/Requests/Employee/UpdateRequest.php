<?php

namespace App\Modules\HR\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'phone' => 'sometimes|unique:employees|digits:10',
            'address' => 'sometimes|max:120',
            'email' => 'required|email|max:100|unique:employees',
            'nationality_id' => 'required|int',
            'date_of_birth' => 'required',
            'marital_status' => 'required|in:single,married,separated,widowed',
            'gender' => 'required|in:male,female',
            'qualification' => 'required',
            'company' => 'required|in:rasidholding,tasahel,rasid,fintech',
            'job_id' => 'required|int',
            'contract_period' => 'sometimes|int',
            'contract_type' => 'sometimes|in:salary,percent,both',
            'salary' => 'required_if:contract_type,==,salary|required_if:contract_type,==,both',
            'salary_percentage' => 'required_if:contract_type,==,percent|required_if:contract_type,==,both',
            'allowances' => 'sometimes|array',
            'allowances.*.allowance_id' => 'required',
            'allowances.*.status' => 'required',
            'allowances.*.value' => 'required_if:allowances.*.status,==,1',
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
