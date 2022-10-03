<?php

namespace App\Modules\Finance\Http\Repositories\ConstraintType;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ConstraintTypeRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function changeStatus($id);
}
