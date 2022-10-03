<?php

namespace App\Foundation\CustomSort;

use Illuminate\Database\Eloquent\Builder;

class sortUsingRelationship implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        $relationships = explode('.', $property);
        $first = @$relationships[0];
        $second = @$relationships[1];
        $foreignKey = @$relationships[2];
        $sortColumn = @$relationships[3];

        return $query->select($second . ".*")
            ->Join($first, "$first.id", '=', "$second.$foreignKey")->orderBy("$first.$sortColumn", $direction);
    }
}
