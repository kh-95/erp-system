<?php

namespace App\Modules\Governance\CustomFilter;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterPlanAtBetween implements Filter
{
    public function __invoke(Builder $query, $value ,  string $property)
    {
        $operator = '>=' ;
        if($property == 'plan_to')
        {
            $operator = '<=' ;
        }
        $property = 'plan_from' ;
        $query->whereDate($property,$operator,$value);
    }
}


