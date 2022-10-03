<?php

namespace App\Modules\HR\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreAllowancesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'allowances' => 'required|array',
            'allowances.allowance_id' => 'required',
            'allowances.status' => 'required',
            'allowances.value' => 'required_if:allowances.*.status,==,1'
        ];
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
