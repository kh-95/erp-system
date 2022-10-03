<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Entities\PermissionRequest;
use Illuminate\Database\Eloquent\Builder;

class PermissionRequestManagementSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(PermissionRequest::getTableName() . ".*")->leftJoin(
            Employee::getTableName(), Employee::getTableName() . '.id', PermissionRequest::getTableName() . '.employee_id')->leftJoin(
            EmployeeJobInformation::getTableName(), EmployeeJobInformation::getTableName() . '.id', PermissionRequest::getTableName() . '.employee_id')->leftJoin(
            Job::getTableName(), Job::getTableName() . '.id', EmployeeJobInformation::getTableName() . '.job_id')->leftJoin(
            Management::getTableName(), Management::getTableName() . '.id', Job::getTableName() . '.management_id')
            ->leftJoin(ManagementTranslation::getTableName() . ' as trans', 'trans.management_id', Management::getTableName() . '.id')
            ->orderBy("trans.$property", $direction);
    }
}
