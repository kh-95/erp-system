<?php

namespace App\Modules\User\Http\Repositories\Permissions;

use App\Repositories\CommonRepositoryInterface;

interface PermissionRepositoryInterface extends CommonRepositoryInterface
{
    public function permissionsForCreateRole();
}
