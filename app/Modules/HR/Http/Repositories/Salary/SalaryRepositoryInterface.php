<?php

namespace App\Modules\HR\Http\Repositories\Salary;

use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\Salary\SalaryRequest;

interface SalaryRepositoryInterface extends CommonRepositoryInterface
{
   public function show($id);
   public function updatedeductPercentage(SalaryRequest $request, $id);
}
