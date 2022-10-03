<?php

namespace App\Modules\HR\Http\Requests\Salary;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'deduction_percentage' => "required|numeric|between:0,100",
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

    protected function prepareForValidation()
{
    $this->merge([
        'deduction_percentage' => (double) $this->deduction_percentage / 100,
    ]);
}
}
