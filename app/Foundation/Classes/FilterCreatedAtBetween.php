<?php

namespace App\Foundation\Classes;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCreatedAtBetween implements Filter
{
    public function __invoke(Builder $query, $value ,  string $property)
    {
        $operator = '>=' ;
        if($property == 'created_to')
        {
            $operator = '<=' ;
        }
        $property = 'created_at' ;
        $query->whereDate($property,$operator,$value);
    }
}


