<?php

namespace App\Modules\RiskManagement\Http\Repositories\Vendor;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Modules\HR\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Repositories\CommonRepositoryInterface;

interface VendorRepositoryInterface extends CommonRepositoryInterface
{
    public function show($id);
    public function getVendor($identity_number);
}
