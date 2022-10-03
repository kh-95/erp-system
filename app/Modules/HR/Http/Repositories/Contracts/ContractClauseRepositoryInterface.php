<?php

namespace App\Modules\HR\Http\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface ContractClauseRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
}
