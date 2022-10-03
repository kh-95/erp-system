<?php

namespace App\Foundation\Classes;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterAmountBetween implements Filter
{
    public function __invoke(Builder $query, $value ,  string $property)
    {
        $operator = '>=' ;
        if($property == 'amount_to')
        {
            $operator = '<=' ;
        }
        $property = 'amount' ;
        $query->where($property,$operator,$value);
    }
}


