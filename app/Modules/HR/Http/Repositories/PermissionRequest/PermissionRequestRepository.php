<?php

namespace App\Modules\HR\Http\Repositories\PermissionRequest;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\CustomSorts\PermissionRequestManagementSort;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\PermissionRequest;
use App\Modules\HR\Entities\Salary;
use App\Modules\HR\Entities\Setting;
use App\Modules\HR\Entities\Vacation;
use App\Modules\HR\Http\Requests\PermissionRequest\PermissionRequestRequest;
use App\Modules\HR\Http\Requests\PermissionRequest\updatePermissionRequestRequest;
use App\Modules\HR\Transformers\PermissionRequestResource;
use App\Modules\User\Entities\Permission;
use App\Repositories\CommonRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use App\Modules\HR\Http\Requests\PermissionRequest\updateHrPermissionRequestRequest;

class PermissionRequestRepository extends CommonRepository implements PermissionRequestRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return PermissionRequest::class;
    }

    public function filterColumns()
    {
        return [
            'employee.jobInformation.job.management.id',
//            AllowedFilter::scope('name_employee'),
            'employee_id',
            'permission_number',
            'date',
//            'direct_manager_status',
            'hr_status'
        ];
    }


    public function sortColumns()
    {
        return [
            'permission_number',
            $this->sortUsingRelationship('employee-name', Employee::getTableName() . '.' . PermissionRequest::getTableName() . '.' . 'employee_id.first_name'),
            AllowedSort::custom('management-name', new PermissionRequestManagementSort(), 'name'),

            'date',
            'from',
            'to',
//            'direct_manager_status',
            'hr_status'
        ];
    }


    public function show($id)
    {
        $permissionRequest = $this->model()::with('employee.job.management')->withTrashed()->findOrFail($id);
        return $this->successResponse(PermissionRequestResource::make($permissionRequest));
    }

    private function remainingTime()
    {
        $permission_duration = isset(Setting::first()->permission_duration) ? Setting::first()->permission_duration : 90;
        $permission_duration_employee = PermissionRequest::where('employee_id', auth()->user()->employee?->id)->where('direct_manager_status', '!=', 'rejected')
            ->whereIn('hr_status', ['waiting', 'accepted'])
            ->whereMonth('date', '=', Carbon::now()->format('m'))->sum('permission_duration');
        $remaining_time = $permission_duration - $permission_duration_employee;

         return $remaining_time;
    }

    public function store(PermissionRequestRequest $request)
    {

        $data = $request->validated();
        $data['employee_id'] = auth()->user()->employee?->id;
        $data['permission_number'] = Helper::generate_unique_code(PermissionRequest::class, 'permission_number', 6, 'numbers');
        $data['permission_duration'] = Carbon::parse($data['from'] . $data['from_duration'])->diffInMinutes(Carbon::parse($data['to'] . $data['to_duration']));
        $data['from'] = Carbon::parse($data['from'] . $data['from_duration'])->format('H:i');
        $data['to'] = Carbon::parse($data['to'] . $data['to_duration'])->format('H:i');
        $data['direct_manager_status'] = PermissionRequest::WAITING;
        $data['hr_status'] = PermissionRequest::WAITING;

//        $salary = EmployeeJobInformation::where('employee_id', auth()->id())->first()->salary;
//        $discount_duration = $this->remainingTime() - $data['permission_duration'];
//        dd($this->remainingTime());

        //        عدد دقائق مدة الخصم *((الراتب الكلي/30) /8/60
//        $data['deduct_amount'] = '';

        $management_id = auth()->user()->employee->jobInformation->job->management_id;
        $job_manager = Job::where(['management_id' => $management_id, 'is_manager' => 1])->first();
        if ($job_manager) {
            $data['employee_manager_id'] = $job_manager->EmployeeJobInformationManager?->employee->id;
        }
        return $this->model->create($data);
    }

    public function updateStatus(updatePermissionRequestRequest $request, PermissionRequest $permissionRequest)
    {
        $permissionRequest->update([
            'direct_manager_status' => $request->status
        ]);

        return $permissionRequest;
    }

    public function updateStatusHr(updateHrPermissionRequestRequest $request, PermissionRequest $permissionRequest)
    {
        $permissionRequest->update([
            'hr_status' => $request->status
        ]);

        return $permissionRequest;
    }

    public function permission_request_managements(Request $request)
    {
        $employee = auth()->user()->employee;
        $management = auth()->user()->employee->jobInformation->job->management;
        if ($employee->is_management_member == 1) {
            return Management::where('id', $management->id)->latest()->paginate(Helper::getPaginationLimit($request));
        }
        return Management::latest()->paginate(Helper::getPaginationLimit($request));
    }
}
