<?php

namespace App\Modules\CustomerService\Http\Repositories\Employee;

use App\Repositories\CommonRepositoryInterface;

interface EmployeeRepositoryInterface extends CommonRepositoryInterface
{

    public function show($id);
}
