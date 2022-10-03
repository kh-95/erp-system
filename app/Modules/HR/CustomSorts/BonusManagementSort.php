<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use Illuminate\Database\Eloquent\Builder;

class BonusManagementSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(DeductBonus::getTableName(). ".*")->leftJoin(
            Management::getTableName(), Management::getTableName().'.id', DeductBonus::getTableName().'.management_id')
            ->leftJoin(ManagementTranslation::getTableName().' as trans', 'trans.management_id', Management::getTableName().'.id')
            ->orderBy("trans.$property", $direction);
    }
}
