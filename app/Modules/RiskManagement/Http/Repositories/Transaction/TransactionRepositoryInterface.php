<?php

namespace App\Modules\RiskManagement\Http\Repositories\Transaction;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Repositories\CommonRepositoryInterface;

interface TransactionRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
}
