<?php

namespace App\Foundation\Classes;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterDeactivatedAt implements Filter
{
    public function __invoke(Builder $query, $value ,  string $property)
    {
        if($value)
        {
           $query->whereNull($property);
        }else{
            $query->whereNotNull($property);
        }
    }
}


