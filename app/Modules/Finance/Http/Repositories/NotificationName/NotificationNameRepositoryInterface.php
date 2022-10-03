<?php

namespace App\Modules\Finance\Http\Repositories\NotificationName;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface NotificationNameRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function changeStatus($id);
}
