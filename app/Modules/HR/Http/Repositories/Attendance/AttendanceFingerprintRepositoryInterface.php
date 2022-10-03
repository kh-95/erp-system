<?php

namespace App\Modules\HR\Http\Repositories\Attendance;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Repositories\CommonRepositoryInterface;

interface AttendanceFingerprintRepositoryInterface extends CommonRepositoryInterface
{
    public function store(StoreAttendanceRequest $request);
    public function updateAttend(UpdateAttendanceRequest $request, Employee $employee);
    public function listMethods();
    public function listBranches();
    public function listPunishments();
    public function listPunishmentStatus();
}
