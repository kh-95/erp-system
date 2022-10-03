<?php

namespace App\Foundation\Classes;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterTranslatedCulmon implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereTranslationLike($property, '%'.$value.'%');
    }
}


