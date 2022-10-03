<?php

namespace App\Modules\Legal\Http\Repositories\OrderModel;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ConsultResponseRepositoryInterface extends CommonRepositoryInterface
{
    public function replay($data, $id);
}
