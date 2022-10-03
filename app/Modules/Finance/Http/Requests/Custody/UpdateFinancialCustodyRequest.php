<?php

namespace App\Modules\Finance\Http\Requests\Custody;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateFinancialCustodyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'bill_number' => 'nullable',
            'tax_number' => 'nullable',
            'supplier_name' => 'nullable',
            'total' => 'nullable',
            'tax' => 'nullable',
            'net' => 'nullable',
            'date' => 'nullable|date',
            'cost_center_id' => 'nullable',
            'allowance_type' => 'nullable',
            'supply_employee_name' => 'nullable',
            'notes' => 'nullable',
            'management_id' => 'nullable',
            'employee_id' => 'nullable',
            'attachments' => 'nullable',
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, response(['error' => $validator->errors()])));
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
