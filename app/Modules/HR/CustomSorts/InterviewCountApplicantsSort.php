<?php

namespace App\Modules\HR\CustomSorts;

use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use Illuminate\Database\Eloquent\Builder;

class InterviewCountApplicantsSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $query->orderBy($property, $direction);
    }


}
