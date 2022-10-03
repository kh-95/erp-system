<?php

namespace App\Modules\RiskManagement\Http\Repositories\Notification;

use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Http\Requests\NotificationRequest;
use App\Repositories\CommonRepositoryInterface;

interface NotificationInterface extends CommonRepositoryInterface
{
    public function store(NotificationRequest $request);
    public function updateNotification(NotificationRequest $request, Notification $notification);
}
