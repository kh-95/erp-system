<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Http\Repositories\Notification\NotificationInterface;
use App\Modules\RiskManagement\Http\Requests\NotificationRequest;
use App\Modules\RiskManagement\Transformers\Notification\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private NotificationInterface $notificationRepository)
    {
        $this->middleware('permission:list-rm_notifications')->only(['index']);
        $this->middleware('permission:create-rm_notifications')->only(['store']);
        $this->middleware('permission:edit-rm_notifications')->only(['update']);
        $this->middleware('permission:delete-rm_notifications')->only(['destroy']);
        $this->middleware('permission:show-rm_notifications')->only(['show']);
    }

    public function index(Request $request)
    {
        $notifications = $this->notificationRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->notificationRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = NotificationResource::collection($notifications);

        return $this->paginateResponse($data, $notifications);
    }

    public function store(NotificationRequest $request)
    {
        $notification = $this->notificationRepository->store($request);
        $data = NotificationResource::make($notification);

        return $this->successResponse($data, message: trans('riskmanagement::messages.notifications.successfully_created'));
    }


    public function show($id)
    {
        return $this->successResponse(NotificationResource::make($this->notificationRepository->show($id)));
    }

    public function update(NotificationRequest $request, Notification $notification)
    {
        $notification =  $this->notificationRepository->updateNotification($request, $notification);

        return $this->successResponse(NotificationResource::make($notification), message: trans('riskmanagement::messages.notifications.successfully_updated'));
    }


    public function destroy($id)
    {
        $this->notificationRepository->delete($id);

        return $this->successResponse(null, message: trans('riskmanagement::messages.notifications.successfully_deleted'));
    }

    public function activities(Notification $notification)
    {
        return $this->notificationRepository->recordActivities($notification->id);
    }
}
