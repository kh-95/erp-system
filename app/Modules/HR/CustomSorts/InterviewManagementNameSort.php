<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use Illuminate\Database\Eloquent\Builder;

class InterviewManagementNameSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(Interview::getTableName() . ".*")->leftJoin(
            Job::getTableName(), Job::getTableName() . '.id', Interview::getTableName() . '.job_id')->leftJoin(
            Management::getTableName(), Management::getTableName() . '.id', Job::getTableName() . '.management_id')
            ->leftJoin(ManagementTranslation::getTableName() . ' as trans', 'trans.management_id', Management::getTableName() . '.id')
            ->orderBy("trans.$property", $direction);
    }


}
