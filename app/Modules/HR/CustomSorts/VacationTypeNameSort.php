<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Vacation;
use App\Modules\HR\Entities\VacationType;
use App\Modules\HR\Entities\VacationTypeTranslation;
use Illuminate\Database\Eloquent\Builder;

class VacationTypeNameSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(Vacation::getTableName() . ".*")->leftJoin(
            VacationType::getTableName(), VacationType::getTableName() . '.id', Vacation::getTableName() . '.vacation_type_id')
            ->leftJoin(VacationTypeTranslation::getTableName() . ' as trans', 'trans.vacation_type_id', VacationType::getTableName() . '.id')
            ->orderBy("trans.$property", $direction);
    }

}
