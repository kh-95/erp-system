<?php

namespace App\Modules\Finance\Http\Repositories\Custody;

use App\Repositories\CommonRepositoryInterface;

interface FinancialCustodyRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
}
