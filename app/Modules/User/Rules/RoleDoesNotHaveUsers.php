<?php

namespace App\Modules\User\Rules;

use App\Modules\User\Entities\User;
use Illuminate\Contracts\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleDoesNotHaveUsers implements Rule
{
    private Role $role;

    public function __construct(int $id, ?bool $force)
    {
        $this->force = $force;
        $this->setRole($id);
    }

    public function passes($attribute, $value) :bool
    {
        return $this->force || $this->checkRoleUsers();
    }

    private function setRole($id) :void
    {
        $this->role = Role::findOrFail($id);
    }

    private function checkRoleUsers() :bool
    {
        return !(bool)User::role($this->role)->count();
    }
    public function message() :string
    {
        return trans('user::validations.roles.have_users');
    }
}
