<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\HR\Http\Requests\VacationRequest;
use App\Modules\HR\Http\Repositories\Vacation\VacationRepositoryInterface;
use App\Modules\HR\Transformers\VacationResource;
use App\Modules\HR\Entities\Vacation;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use Illuminate\Http\Request;


class VacationController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var VacationRepository
     */
    private VacationRepositoryInterface  $vacationRepository;
    /**
     * Create a new VacationController instance.
     *
     * @param VacationRepository $VacationRepository
     */
    public function __construct(VacationRepositoryInterface $vacationRepository)
    {
        $this->vacationRepository = $vacationRepository;

        $this->middleware('permission:list-vacation')->only(['index']);
        $this->middleware('permission:create-vacation')->only(['store']);
        $this->middleware('permission:edit-vacation')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-vacation')->only(['destroy']);
        $this->middleware('permission:show-vacation')->only(['show']);


    }

    /**
     * Get all vacations
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $vacations = $this->vacationRepository->setfilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->vacationRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = VacationResource::collection($vacations);
        return $this->paginateResponse($data,$vacations);
    }

    /**
     * Create a vacations.
     *
     * @param vacationRequest $request
     * @return JsonResponse
     */
    public function store(VacationRequest $request): JsonResponse
    {
        return $this->vacationRepository->store($request);
    }

    /**
     * Show the specified Vacation.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $vacation = $this->vacationRepository->find($id)->load('activities');
        return $this->successResponse(new VacationResource($vacation));
    }
    /**
     * Show the specified Vacation.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $vacation = $this->vacationRepository->find($id);
        return $this->successResponse(new VacationResource($vacation));
    }

    /**
     * Update the specified Vacation.
     *
     * @param VacationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(VacationRequest $request, $id): JsonResponse
    {
        return $this->vacationRepository->updatevacation($request->validated(), $id);
    }

    /**
     * Remove the specified vacation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->vacationRepository->destroy($id);
    }

    /**
     * togglestatus the specified vacation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->vacationRepository->changeStatus($id);
    }

    /**
     * calculate vacation balance the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatebalance($employee_id,$type_id): JsonResponse
    {
        return $this->vacationRepository->calculatebalance($employee_id,$type_id);
    }

}
