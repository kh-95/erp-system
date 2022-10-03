<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {
        return [
            'employee_id' => 'required|unique:users|exists:employees,id',
            'employee_number' => 'required|unique:users|digits:6|int|exists:employee_job_information,employee_number',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:3000',
            'password' => 'required|digits_between:6,10',
            'is_send_otp' => 'required|boolean',
            'roles' => 'sometimes|array',
            'permissions' => 'sometimes|array',
        ];
    }

    private function updateRules() :array
    {
        return [
            'is_send_otp' => 'sometimes|boolean',
            'password' => [
                'sometimes',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'roles' => 'sometimes|array',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:3000',
            'permissions' => 'sometimes|array',
            'status' => 'sometimes|in:enable,disable,disable_for_a_while',
            'disable_from' => 'required_if:status,==,disable_for_a_while|date|date_format:d-m-Y|after_or_equal:today,d-m-Y',
            'disable_to' => 'required_if:status,==,disable_for_a_while|date|date_format:d-m-Y|after:disable_from'
        ];
    }


    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'image.mimes' => trans('user::validations.image.mimes'),
            'image.max' => trans('user::validations.image.max'),
            'employee_id.required' => trans('user::validations.employee_id.required'),
            'employee_id.exists' => trans('user::validations.employee.required'),
            'employee_id.unique' => trans('user::validations.employee_id.unique'),
            'employee_number.required' => trans('user::validations.employee_number.required'),
            'employee_number.digits' => trans('user::validations.employee_number.digits'),
            'password.required' => trans('user::validations.password.required'),
            'password.digits_between' => trans('user::validations.password.digits_between'),
            'is_send_otp.required' => trans('user::validations.is_send_otp.required'),
        ];
    }
}
