<?php

namespace App\Modules\RiskManagement\Http\Repositories\NotificationVendor;

use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Http\Requests\TakenActionRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface NotificationVendorRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function takeAction(NotificationVendor $notificationVendor, TakenActionRequest $request);
}
