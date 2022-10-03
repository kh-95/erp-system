<?php

namespace App\Modules\HR\Http\Requests\Salary;

use Illuminate\Foundation\Http\FormRequest;

class SalaryApproveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'id' => 'required|exists:hr_salary_approves,id',
            'is_signed' => "nullable|in:0,1",
            'is_paid' => "nullable|in:0,1"

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
