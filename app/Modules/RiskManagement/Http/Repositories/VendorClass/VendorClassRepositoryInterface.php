<?php

namespace App\Modules\RiskManagement\Http\Repositories\VendorClass;

use App\Repositories\CommonRepositoryInterface;

interface VendorClassRepositoryInterface extends CommonRepositoryInterface
{

    public function listClasses();

}
