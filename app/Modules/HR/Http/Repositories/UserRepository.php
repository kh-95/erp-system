<?php

namespace App\Modules\HR\Http\Repositories;

use App\Modules\HR\Entities\User;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends CommonRepository implements UserRepositoryInterface
{

    protected function filterColumns() :array
    {
        return [
            'name'
        ];
    }

    public function model()
    {
        return User::class;
    }
}
