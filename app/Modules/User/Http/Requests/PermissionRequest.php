<?php

namespace App\Modules\User\Http\Requests;

use App\Modules\User\Rules\PermissionDoesNotHaveUsersOrRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    public function rules()
    {
        return request()->method() === 'POST' ? $this->storeRules() : $this->updateRules();
    }

    private function storeRules() :array
    {
        return [
            'name' => 'required|unique:permissions|max:100',
            'slug' => 'required|unique:permissions|max:100',
            'module' => 'required|max:100',
            'deactivated_at' => 'sometimes|boolean'
        ];
    }

    private function updateRules() :array
    {
        return [
            'name' => [
                'sometimes',
                'max:100',
                Rule::unique('permissions')->ignore($this->permission, 'id')
            ],
            'slug' => [
                'sometimes',
                'max:100',
                Rule::unique('permissions')->ignore($this->permission, 'id')
            ],
            'module' => [
                'sometimes',
                'max:100',
            ],
            'force_deactivated' => [
                'sometimes',
                'boolean',
            ],
            'deactivated_at' => [
                'sometimes',
                'boolean',
                new PermissionDoesNotHaveUsersOrRole($this->permission, $this->force_deactivated)
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
            'name.required' => trans('user::validations.permissions.required_name'),
            'name.unique' => trans('user::validations.permissions.unique_name'),
            'slug.required' => trans('user::validations.permissions.required_slug'),
            'slug.unique' => trans('user::validations.permissions.unique_slug'),
        ];
    }
}


