<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Http\Repositories\NotificationVendor\NotificationVendorRepositoryInterface;
use App\Modules\RiskManagement\Http\Requests\TakenActionRequest;
use App\Modules\RiskManagement\Transformers\NotificationVendorResource;
use App\Repositories\AttachesRepository;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationVendorController extends Controller
{
    use ApiResponseTrait, ImageTrait;

    public function __construct(private NotificationVendorRepositoryInterface $notificationRepository)
    {
        // $this->middleware('permission:list-risk_management_notifications')->only(['index']);
    }

    public function index(Request $request)
    {
        $notifications = $this->notificationRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->notificationRepository->sortColumns())
            ->with(['vendor', 'notification'])
            ->paginate(Helper::getPaginationLimit($request));
        $data = NotificationVendorResource::collection($notifications);

        return $this->paginateResponse($data, $notifications);
    }

    public function show($id)
    {
        return $this->apiResource(NotificationVendorResource::make($this->notificationRepository->show($id)));
    }

    public function takeAction(NotificationVendor $notificationVendor, TakenActionRequest $request)
    {
        $notificationVendor->takenAction()->create(Arr::except($request->validated(), 'attachments'));
        $notificationVendor->update(['taken_action' => $request->taken_action]);

        if (array_key_exists('attachments', $request->validated()) && @$request->attachments[0] != null) {
            $this->deleteImages($notificationVendor->takenAction->attachments);
            $attaches = new AttachesRepository('notification_vendor_attachments', $request,  $notificationVendor->takenAction);
            $attaches->addAttaches();
        }

        return $this->apiResource(NotificationVendorResource::make($notificationVendor->load(['takenAction.attachments'])), message: trans('riskmanagement::messages.notifications.successfully_taken'));
    }

    private function deleteImages($committee_attaches)
    {
        $committee_attaches->map(function ($item) {
            $this->deleteImage($item->file, 'notification_vendor_attachments');
            $item->delete();
        });
    }

    public function activities(NotificationVendor $notificationVendor)
    {
        return $this->notificationRepository->recordActivities($notificationVendor->id);
    }

}
