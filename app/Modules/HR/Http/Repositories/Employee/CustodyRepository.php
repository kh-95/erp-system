<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Modules\HR\Entities\Custody;
use App\Repositories\CommonRepository;

class CustodyRepository extends CommonRepository implements CustodyRepositoryInterface
{
    public function model()
    {
        return Custody::class;
    }
}
