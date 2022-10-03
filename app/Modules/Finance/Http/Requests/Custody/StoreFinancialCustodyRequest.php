<?php

namespace App\Modules\Finance\Http\Requests\Custody;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreFinancialCustodyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'bill_number' => 'required',
            'tax_number' => 'required',
            'supplier_name' => 'required',
            'total' => 'required',
            'tax' => 'required',
            'net' => 'required',
            'date' => 'required|date',
            'cost_center_id' => 'required',
            'allowance_type' => 'required',
            'supply_employee_name' => 'required',
            'notes' => 'nullable',
            'management_id' => 'required',
            'employee_id' => 'required',
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
