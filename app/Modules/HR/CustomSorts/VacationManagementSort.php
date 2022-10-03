<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Entities\Vacation;
use Illuminate\Database\Eloquent\Builder;

class VacationManagementSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(Vacation::getTableName() . ".*")->leftJoin(
            Employee::getTableName(), Employee::getTableName() . '.id', Vacation::getTableName() . '.vacation_employee_id')->leftJoin(
            EmployeeJobInformation::getTableName(), EmployeeJobInformation::getTableName() . '.id', Vacation::getTableName() . '.vacation_employee_id')->leftJoin(
            Job::getTableName(), Job::getTableName() . '.id', EmployeeJobInformation::getTableName() . '.job_id')->leftJoin(
            Management::getTableName(), Management::getTableName() . '.id', Job::getTableName() . '.management_id')
            ->leftJoin(ManagementTranslation::getTableName() . ' as trans', 'trans.management_id', Management::getTableName() . '.id')
            ->orderBy("trans.$property", $direction);
    }

}
