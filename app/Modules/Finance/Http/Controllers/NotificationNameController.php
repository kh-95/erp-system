<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\NotificationNameRequest;
use App\Modules\Finance\Http\Requests\NotificationNameUpdateRequest;
use App\Modules\Finance\Http\Repositories\NotificationName\NotificationNameRepositoryInterface;
use App\Modules\Finance\Transformers\NotificationNameResource;
use App\Modules\Finance\Entities\NotificationName;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class NotificationNameController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var NotificationNameRepository
     */
    private NotificationNameRepositoryInterface  $notificationnameRepository;
    /**
     * Create a new ExpenseTypeController instance.
     *
     * @param ExpenseTypeRepository $expensetypeRepository
     */
    public function __construct(NotificationNameRepositoryInterface $notificationnameRepository)
    {
        $this->notificationnameRepository = $notificationnameRepository;
        $this->middleware('permission:list-notificationname')->only(['index', 'show']);
        $this->middleware('permission:create-notificationname')->only(['store']);
        $this->middleware('permission:edit-notificationname')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-notificationname')->only(['destroy']);

    }

    /**
     * Get all expense types
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $types = $this->notificationnameRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = NotificationNameResource::collection($types);
        return $this->paginateResponse($data,$types);
    }

    /**
     * Create a notificationname.
     *
     * @param NotificationNameRequest $request
     * @return JsonResponse
     */
    public function store(NotificationNameRequest $request): JsonResponse
    {
        return $this->notificationnameRepository->store($request);
    }

    /**
     * Show the specified notificationname.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        
        $type = $this->notificationnameRepository->find($id)->load('activities');
        return $this->successResponse(new NotificationNameResource($type));
    }
    /**
     * Show the notificationname.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $type = $this->notificationnameRepository->find($id);
        return $this->successResponse(new NotificationNameResource($type));
    }

    /**
     * Update the notificationname.
     *
     * @param ConstraitTypeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(NotificationNameUpdateRequest $request, $id): JsonResponse
    {
        return $this->notificationnameRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the notificationname.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->notificationnameRepository->destroy($id);
    }

    /**
     * togglestatus the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->notificationnameRepository->changeStatus($id);
    }

}
