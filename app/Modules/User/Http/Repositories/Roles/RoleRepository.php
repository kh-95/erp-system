<?php

namespace App\Modules\User\Http\Repositories\Roles;

use App\Modules\User\Entities\Role;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedFilter;

class RoleRepository extends CommonRepository implements RoleRepositoryInterface
{

    public function filterColumns()
    {
        return [
            'id',
            'name',
            AllowedFilter::scope('active'),
            AllowedFilter::scope('disabled'),

        ];
    }

    public function model()
    {
        return Role::class;
    }

}
