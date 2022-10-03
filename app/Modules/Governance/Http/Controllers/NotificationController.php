<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Entities\Notification;
use App\Modules\Governance\Http\Repositories\Notification\NotificationRepositoryInterface;
use App\Modules\Governance\Http\Requests\NotificationRequest;
use App\Modules\Governance\Http\Requests\NotificationResponseRequest;
use App\Modules\Governance\Transformers\Notification\NotificationResource;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private NotificationRepositoryInterface $notificationRepository,
        private ManagementRepositoryInterface $managementRepository,
        private EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->middleware('permission:list-governance_notifications')->only(['index']);
        $this->middleware('permission:create-governance_notifications')->only(['store']);
        $this->middleware('permission:edit-governance_notifications')->only(['update']);
        $this->middleware('permission:show-governance_notifications')->only(['show']);
    }

    public function index(Request $request)
    {
        $fingerprints = $this->notificationRepository
            ->setFilters()
            ->when($request->is_own, fn ($q) => $q->whereHas('employee', fn ($query) => $query->where('id', auth()->id())))
            ->defaultSort('-created_at')
            ->allowedSorts($this->notificationRepository->sortColumns())
            ->with('attachments')
            ->paginate(Helper::getPaginationLimit($request));

        $data = NotificationResource::collection($fingerprints);

        return $this->paginateResponse($data, $fingerprints);
    }

    public function store(NotificationRequest $request)
    {
        $notification =  $this->notificationRepository->store($request);

        return $this->apiResource(
            NotificationResource::make($notification),
            message: trans('governance::messages.general.successfully_created')
        );
    }
    public function storeResponse(NotificationResponseRequest $request, $id)
    {
        return $this->successResponse(
            NotificationResource::make($this->notificationRepository->storeResponse($request, $id)),
            message: trans('governance::messages.general.successfully_added')
        );
    }
    public function show($id)
    {
        return $this->apiResource(NotificationResource::make($this->notificationRepository->show($id)));
    }

    public function update(NotificationRequest $request, Notification $governanceNotification)
    {
        $notification = $this->notificationRepository->updateNotification($request, $governanceNotification);

        return $this->apiResource(NotificationResource::make($notification));
    }

    public function listActiveManagements()
    {
        return $this->successResponse($this->managementRepository->listManagement());
    }

    public function listActiveEmployees(Request $request)
    {
        return $this->successResponse($this->employeeRepository->listEmployees($request));
    }
}
