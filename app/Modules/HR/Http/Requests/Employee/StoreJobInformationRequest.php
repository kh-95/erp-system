<?php

namespace App\Modules\HR\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreJobInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'job_id' => 'required|int',
            'receiving_work_date' => 'required|date',
            'contract_period' => 'required|int',
            'contract_type' => 'required|in:salary,percent,both',
            'salary' => 'required_if:contract_type,==,salary|required_if:contract_type,==,both',
            'salary_percentage' => 'required_if:contract_type,==,percent|required_if:contract_type,==,both',
            'employee_number' => 'required',
            'employee_id' => 'required'
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
}
