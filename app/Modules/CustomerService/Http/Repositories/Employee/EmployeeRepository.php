<?php

namespace App\Modules\CustomerService\Http\Repositories\Employee;


use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\CustomerService\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\CustomerService\Transformers\EmployeeDetailsResource;
use App\Modules\CustomerService\Transformers\EmployeeResource;
use App\Modules\HR\Entities\Employee;
use App\Repositories\CommonRepository;


class EmployeeRepository extends CommonRepository implements EmployeeRepositoryInterface
{
    use  ApiResponseTrait;

    public function model()
    {
        return Employee::class;
    }

    public function filterColumns()
    {
        return [
            'id',
            'first_name',
            'jobInformation.employee_number',
            'call_status',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'first_name',
            'jobInformation.employee_number',
            'calls_count',
            'messages_count',
            'calls_duration',
            'calls_average',
            'call_status'
        ];
    }


    public function show($id)
    {
        $employee = $this->find($id);
        return $this->apiResource(EmployeeDetailsResource::make($employee), true);
    }
}
