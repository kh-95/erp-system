<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\AttendanceFingerprint;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Repositories\Attendance\AttendanceFingerprintRepositoryInterface;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Modules\HR\Services\CheckAttendance;
use App\Modules\HR\Transformers\AttendanceResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AttendanceFingerprintController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private AttendanceFingerprintRepositoryInterface $attendanceFingerprintRepository,
        private ManagementRepositoryInterface            $managementRepository,
        private EmployeeRepositoryInterface              $employeeRepository
    ) {

        $this->middleware('permission:updateAttend-attendance_fingerprints')->only(['updateAttend']);
        $this->middleware('permission:listFingerprint-attendance_fingerprints')->only(['listFingetprint']);
        $this->middleware('permission:list-attendance_fingerprints')->only(['index']);
        $this->middleware('permission:create-attendance_fingerprints')->only(['store']);
    }

    public function index(Request $request)
    {
        $fingerprints = $this->attendanceFingerprintRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->attendanceFingerprintRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = AttendanceResource::collection($fingerprints);

        return $this->paginateResponse($data, $fingerprints);
    }

    public function listFingerprint(Request $request)
    {
        $fingerprints = $this->attendanceFingerprintRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->attendanceFingerprintRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = AttendanceResource::collection($fingerprints);

        return $this->paginateResponse($data, $fingerprints);
    }


    public function listManagements()
    {
        $allManagements = $this->managementRepository->listManagement();
        return $this->successResponse($allManagements);
    }

    public function listEmployees(Request $request)
    {
        $allEmployees = $this->employeeRepository->listEmployees($request);
        return $this->successResponse($allEmployees);
    }

    public function listMethods()
    {
        $allMethods = $this->attendanceFingerprintRepository->listMethods();
        return $this->successResponse($allMethods);
    }

    public function listBranches()
    {
        $branches = $this->attendanceFingerprintRepository->listBranches();
        return $this->successResponse($branches);
    }

    public function listPunishments()
    {
        $punishments = $this->attendanceFingerprintRepository->listPunishments();
        return $this->successResponse($punishments);
    }

    public function listPunishmentStatus()
    {
        $punishmentStatus = $this->attendanceFingerprintRepository->listPunishmentStatus();
        return $this->successResponse($punishmentStatus);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $attendance = $this->attendanceFingerprintRepository->store($request);
        CheckAttendance::checkAttendacne($attendance);
        $data = AttendanceResource::make($attendance);
        return $this->successResponse($data, message: trans('hr::messages.attendance.successfully_created'));
    }


    public function updateAttend(UpdateAttendanceRequest $request, Employee $employee)
    {
        $updatedAttendance = $this->attendanceFingerprintRepository->updateAttend($request, $employee);
        CheckAttendance::checkAttendacne($updatedAttendance);
        return $this->successResponse($updatedAttendance, message: trans('hr::messages.attendance.successfully_updated'));
    }
}
