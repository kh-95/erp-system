<?php

namespace App\Modules\User\Http\Requests;

use App\Modules\User\Rules\RoleDoesNotHaveUsers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {
        return [
            'name' => 'required|unique:roles|max:100',
            'slug' => 'required|unique:roles|max:100',
            'permissions' => 'required|array',
            'permissions.*' => 'int'
        ];
    }

    private function updateRules() :array
    {
        return [
            'name' => [
                'sometimes',
                'max:100',
                Rule::unique('roles')->ignore($this->role, 'id')
            ],
            'slug' => [
                'sometimes',
                'max:100',
                Rule::unique('roles')->ignore($this->role, 'id')
            ],
            'deactivated_at' => [
                'sometimes',
                'boolean',
                new RoleDoesNotHaveUsers($this->role,$this->force_deactivated)
            ],
        ];
    }


    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('user::validations.roles.required_name'),
            'name.unique' => trans('user::validations.roles.unique_name'),
            'slug.required' => trans('user::validations.roles.required_slug'),
            'slug.unique' => trans('user::validations.roles.unique_slug'),
            'permissions.required' => trans('user::validations.roles.required_permissions'),
        ];
    }
}


