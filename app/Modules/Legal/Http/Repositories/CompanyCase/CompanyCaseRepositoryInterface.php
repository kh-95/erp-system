<?php

namespace App\Modules\Legal\Http\Repositories\CompanyCase;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Modules\Legal\Http\Requests\CompanyCaseRequest;
use App\Repositories\CommonRepositoryInterface;

interface CompanyCaseRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);

    public function store(CompanyCaseRequest $request);

    public function updateCompanyCase(CompanyCaseRequest $request,$id);
}
