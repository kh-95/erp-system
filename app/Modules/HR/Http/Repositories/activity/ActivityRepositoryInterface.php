<?php

namespace App\Modules\HR\Http\Repositories\activity;

use App\Repositories\CommonRepositoryInterface;

interface ActivityRepositoryInterface extends CommonRepositoryInterface
{
    public function index();
}
