<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface CommonRepositoryInterface extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function setFilters();

    public function translated($culomn);

    public function forExternalServices(array $attributes);

    public function toggleStatus(int $id);

    public function onlyTrashed();

    public function doesntHaveRelations(int $id, array $relations) :bool ;

}
