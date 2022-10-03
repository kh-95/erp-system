<?php

namespace App\Modules\Collection\Http\Repositories;

use App\Repositories\CommonRepositoryInterface;

interface InstallmentRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
}
