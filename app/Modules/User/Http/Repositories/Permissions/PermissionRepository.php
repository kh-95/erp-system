<?php

namespace App\Modules\User\Http\Repositories\Permissions;

use App\Modules\User\Entities\Permission;
use App\Repositories\CommonRepository;

class PermissionRepository extends CommonRepository implements PermissionRepositoryInterface
{
    public function filterColumns()
    {
        return [
            'id',
            'name',
            'slug',
            'module'
        ];
    }

    public function model()
    {
        return Permission::class;
    }

    public function permissionsForCreateRole()
    {
        return $this->findWhere(['deactivated_at' => null])->pluck('slug', 'id')->toArray();
    }
}
