<?php

namespace App\Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionDoesNotHaveUsersOrRole implements Rule
{
    private Permission $permission;
    private ?bool $force;

    public function __construct(int $id, ?bool $force)
    {
        $this->force = $force;
        $this->setPermission($id);
    }

    private function setPermission($id)
    {
        return $this->permission = Permission::findOrFail($id);
    }

    public function passes($attribute, $value)
    {
        return  $this->force || ($this->checkPermissionUsers() && $this->checkPermissionRoles());
    }

    public function message()
    {
        return trans('user::validations.permissions.have_users_or_roles');
    }

    private function checkPermissionUsers() :bool
    {
        return !(bool)$this->permission->users->count();
    }

    private function checkPermissionRoles() :bool
    {
        return !(bool)$this->permission->roles->count();
    }
}
