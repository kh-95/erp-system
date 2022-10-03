<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use Illuminate\Database\Eloquent\Builder;

class InterviewJobNameSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->select(Interview::getTableName() . ".*")->leftJoin(
            Job::getTableName(), Job::getTableName() . '.id', Interview::getTableName() . '.job_id')
            ->leftJoin(JobTranslation::getTableName() . ' as trans', 'trans.job_id', Job::getTableName() . '.id')
            ->orderBy("trans.$property", $direction);
    }


}
