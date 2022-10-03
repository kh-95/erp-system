<?php

namespace App\Modules\Governance\Http\Repositories\Meeting;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Employee;
use Carbon\Carbon;

trait EmployeeDoesntHaveMeetings
{
    use ApiResponseTrait;
    protected function getFreeEmployees($management_id_para,$start_at_para,$end_at_para)
    {
        $employeeTableName = Employee::getTableName();
        $employees = Employee::whereHas('job', function ($q) use ($management_id_para) {
            $q->where('management_id', $management_id_para);
        })->where(function ($q) use ($start_at_para,$end_at_para) {
            $q->whereDoesntHave('governanceMeetings', function ($q) use ($start_at_para,$end_at_para) {
                $start_at = Carbon::parse($start_at_para)->toDateTimeString();
                $end_at = Carbon::parse($end_at_para)->toDateTimeString();
                $q->whereBetween('start_at', [$start_at, $end_at])->orWhereBetween('end_at', [$start_at, $end_at]);
            })->doesntHave('governanceMeetings');
        })->select($employeeTableName . '.id', \DB::raw("CONCAT($employeeTableName.first_name ,' ', $employeeTableName.second_name,' ' , $employeeTableName.third_name ,' ' ,$employeeTableName.last_name) as name"))
            ->get();
            return $this->successResponse(data:$employees);
    }
}
