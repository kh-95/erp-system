<?php

namespace App\Modules\Finance\Http\Repositories;

use App\Repositories\CommonRepositoryInterface;

interface AssetRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
}
