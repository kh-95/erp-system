<?php

namespace App\Foundation\Classes;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterTotalPaysBetween implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $operator = '>=';
        if ($property == 'total_pays_to') {
            $operator = '<=';
        }
        $property = 'total_pays';
        $query->where($property, $operator, $value);
    }
}


