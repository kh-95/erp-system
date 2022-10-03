<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Builder;

class BonusEmployeeNumberSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(DeductBonus::getTableName(). ".*")->leftJoin(Employee::getTableName(), Employee::getTableName().'.id', DeductBonus::getTableName().'.employee_id')
            ->leftJoin('users', 'users.employee_id',Employee::getTableName() .'.id')
            ->orderBy("users.$property", $direction);
    }
}
