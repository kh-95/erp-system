<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\PermissionRequest;
use App\Modules\HR\Http\Repositories\PermissionRequest\PermissionRequestRepositoryInterface;
use App\Modules\HR\Http\Requests\PermissionRequest\PermissionRequestRequest;
use App\Modules\HR\Http\Requests\PermissionRequest\updatePermissionRequestRequest;
use App\Modules\HR\Http\Requests\PermissionRequest\updateHrPermissionRequestRequest;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\HR\Transformers\PermissionRequestResource;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PermissionRequestController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private PermissionRequestRepositoryInterface $permissionRequestRepository,
    ) {
        $this->middleware('permission:list-permission_requests')->only(['index']);
        $this->middleware('permission:updateStatusByManager')->only(['updateStatusByManager']);
        $this->middleware('permission:updateStatusByHr')->only(['updateStatusByHr']);
        $this->middleware('permission:create-permission_requests')->only(['store']);
        $this->middleware('permission:archive')->only(['archive']);
        $this->middleware('permission:show-permission_requests')->only(['show']);
        $this->middleware('permission:delete-permission_requests')->only(['destroy']);
    }

    public function index(Request $request)
    {
//      return PermissionRequest::whereMonth('created_at', '=', Carbon::now()->format('m'))->get();
        $fingerprints = $this->permissionRequestRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->permissionRequestRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = PermissionRequestResource::collection($fingerprints);

        return $this->paginateResponse($data, $fingerprints);
    }


    public function store(PermissionRequestRequest $request)
    {
        $permissionRequest = $this->permissionRequestRepository->store($request);
        $allDonePermissionRequestsDuration = auth()->user()->employee->permissionRequests()
            ->where(
                'hr_status',
                [
                    PermissionRequest::ACCEPTED_WITH_DEDUCT,
                    PermissionRequest::ACCEPTED_WITHOUT_DEDUCT
                ]
            )->where('direct_manager_status', [PermissionRequest::ACCEPTED])
            ->sum('permission_duration');

        $permissionRequest->allDonePermissionRequestsDuration = $allDonePermissionRequestsDuration;
        $data = PermissionRequestResource::make($permissionRequest);

        return $this->successResponse(data:$data, message:trans('hr::messages.permission_requests.successfully_created', ['number' => $data->permission_number]));
    }


    public function show($id)
    {
        return $this->permissionRequestRepository->show($id);
    }


    public function updateStatusByManager(updatePermissionRequestRequest $request, PermissionRequest $permissionRequest)
    {
        $updatedPermissionRequest = $this->permissionRequestRepository->updateStatus($request, $permissionRequest);

        return $this->successResponse($updatedPermissionRequest, message: trans('hr::messages.permission_requests.successfully_updated'));
    }

    public function updateStatusByHr(updateHrPermissionRequestRequest $request, PermissionRequest $permissionRequest)
    {
        $updatedPermissionRequest = $this->permissionRequestRepository->updateStatusHr($request, $permissionRequest);
        return $this->successResponse($updatedPermissionRequest, message: trans('hr::messages.permission_requests.successfully_updated'));
    }


    public function archive(Request $request)
    {
        $permissionRequests = $this->permissionRequestRepository
            ->onlyTrashed()
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->permissionRequestRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data['managements'] = PermissionRequestResource::collection($permissionRequests);

        return $this->successResponse($data);
    }

    public function destroy($id)
    {
        $this->permissionRequestRepository->delete($id);
        return $this->successResponse(null, message: trans('hr::messages.permission_requests.successfully_deleted'));
    }

    public function permission_request_managements(Request $request){

        $mangments = $this->permissionRequestRepository->permission_request_managements($request);
        $data = ManagementResource::collection($mangments);
        return $this->paginateResponse($data, $mangments);
    }
}
