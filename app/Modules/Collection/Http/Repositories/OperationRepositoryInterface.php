<?php

namespace App\Modules\Collection\Http\Repositories;

use App\Repositories\CommonRepositoryInterface;

interface OperationRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
}
