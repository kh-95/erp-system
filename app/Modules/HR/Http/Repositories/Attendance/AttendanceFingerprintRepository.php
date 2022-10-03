<?php

namespace App\Modules\HR\Http\Repositories\Attendance;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\AttendanceFingerprint;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Repositories\CommonRepository;

class AttendanceFingerprintRepository extends CommonRepository implements AttendanceFingerprintRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return AttendanceFingerprint::class;
    }

    public function filterColumns()
    {
        return [
            'employee_id',
            'employee.identification_number',
            'method',
            'branch'
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'employee.first_name',
            'employee.second_name',
            'employee.third_name',
            'employee.last_name',
            'employee.identification_number',
            'employee.job.management.id',
            'branch',
            'method',
            'created_at'
        ];
    }

    public function listBranches()
    {
        return collect(AttendanceFingerprint::BRANCHES)->map(function ($item) {
            $data['name'] = $item;
            $data['trans'] = trans('hr::hr.attendance.branches.' . $item);
            return $data;
        });
    }


    public function listMethods()
    {
        return collect(AttendanceFingerprint::METHODS)->map(function ($item) {
            $data['name'] = $item;
            $data['trans'] = trans('hr::hr.attendance.methods.' . $item);
            return $data;
        });
    }

    public function listPunishments()
    {
        return collect(AttendanceFingerprint::PUNISHMENT)->map(function ($item) {
            $data['name'] = $item;
            $data['trans'] = trans('hr::hr.attendance.punishments.' . $item);
            return $data;
        });
    }


    public function listPunishmentStatus()
    {
        return collect(AttendanceFingerprint::PUNISHMENT_STATUS)->map(function ($item) {
            $data['name'] = $item;
            $data['trans'] = trans('hr::hr.attendance.punishment_status.' . $item);
            return $data;
        });
    }

    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->all();
        $attendance = $this->model()::create($data);
        return $attendance;
    }

    public function updateAttend(UpdateAttendanceRequest $request, Employee $employee)
    {
        $data = $request->validated();
        $attendance = $this->model()::where('employee_id', $employee->id)
            ->whereDate('created_at', $data['date'] . ' 00:00:00')->first();
            $attendance->update(['leaved_at' => $data['leaved_at']]);

        return $attendance;
    }
}
