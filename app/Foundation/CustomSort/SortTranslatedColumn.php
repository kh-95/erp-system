<?php

namespace App\Foundation\CustomSort;

use Illuminate\Database\Eloquent\Builder;

class SortTranslatedColumn implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        return $query->orderByTranslation($property, $direction);
    }
}
