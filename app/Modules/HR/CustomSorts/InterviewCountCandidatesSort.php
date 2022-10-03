<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use Illuminate\Database\Eloquent\Builder;

class InterviewCountCandidatesSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->select(Interview::getTableName() . ".*",\DB::raw('count('.InterviewApplication::getTableName().'.recommended) as ' . $property))->leftJoin(
            InterviewApplication::getTableName(), InterviewApplication::getTableName() . '.interview_id', Interview::getTableName() . '.id')
            ->where('recommended', 1)
            ->groupBy(InterviewApplication::getTableName().'.interview_id')->orderBy('count_candidates', $direction);
    }


}
