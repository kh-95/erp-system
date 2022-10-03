<?php

namespace App\Modules\Governance\Http\Repositories\Notification;

use App\Modules\Governance\Entities\Notification;
use App\Modules\Governance\Http\Requests\NotificationRequest;
use App\Modules\Governance\Http\Requests\NotificationResponseRequest;
use App\Repositories\CommonRepositoryInterface;

interface NotificationRepositoryInterface extends CommonRepositoryInterface
{
    public function store(NotificationRequest $request);
    public function updateNotification(NotificationRequest $request, Notification $notification);
    public function storeResponse(NotificationResponseRequest $request, $id);
}
