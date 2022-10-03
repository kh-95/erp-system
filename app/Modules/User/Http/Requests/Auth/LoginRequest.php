<?php

namespace App\Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_number' => 'required|exists:users,employee_number',
            'password' => 'required',
            'otp' => 'sometimes|int'
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

    public function messages()
    {
        return [
            'employee_number.required' => trans('user::auth.employee_number_required'),
            'employee_number.exists' => trans('user::auth.employee_number_exists'),
            'password.required' => trans('user::auth.password_required'),
            'otp.int' => trans('user::auth.otp_int'),
        ];
    }
}
