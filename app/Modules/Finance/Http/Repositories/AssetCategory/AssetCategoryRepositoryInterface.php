<?php

namespace App\Modules\Finance\Http\Repositories\AssetCategory;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface AssetCategoryRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function changeStatus($id);
}
