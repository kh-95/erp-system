<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\HR\Http\Requests\VacationTypeRequest;
use App\Modules\HR\Http\Repositories\VacationType\VacationTypeRepositoryInterface;
use App\Modules\HR\Transformers\VacationTypeResource;
use App\Modules\HR\Entities\VacationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class VacationTypeController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var VacationTypeRepository
     */
    private VacationTypeRepositoryInterface  $vacationtypeRepository;
    /**
     * Create a new VacationTypeController instance.
     *
     * @param VacationTypeRepository $VacationTypeRepository
     */
    public function __construct(VacationTypeRepositoryInterface $vacationtypeRepository)
    {
        $this->vacationtypeRepository = $vacationtypeRepository;
        $this->middleware('permission:list-vacationtype')->only(['index', 'show','forExternalServices']);
        $this->middleware('permission:create-vacationtype')->only(['store']);
        $this->middleware('permission:edit-vacationtype')->only(['update','togglestatus']);
        $this->middleware('permission:delete-vacationtype')->only(['destroy']);
        $this->middleware('permission:archive-vacationtype')->only(['onlyTrashed','restore']);

    }

    /**
     * Get all vacation type
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $types = $this->vacationtypeRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = VacationTypeResource::collection($types);
        return $this->paginateResponse($data,$types);
    }

    /**
     * Create a vacation type.
     *
     * @param vacationtypeRequest $request
     * @return JsonResponse
     */
    public function store(VacationTypeRequest $request): JsonResponse
    {
        return $this->vacationtypeRepository->store($request);
    }

    /**
     * Show the specified VacationType.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $type = $this->vacationtypeRepository->find($id);
        return $this->successResponse(new VacationTypeResource($type));
    }

    public function edit($id): JsonResponse
    {
        $type = $this->vacationtypeRepository->find($id);
        return $this->successResponse(new VacationTypeResource($type));
    }

    /**
     * Update the specified VacationType.
     *
     * @param VacationTypeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(VacationTypeRequest $request, $id): JsonResponse
    {
        return $this->vacationtypeRepository->updatevacationtype($request, $id);
    }

    /**
     * Remove the specified vacationtype.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->vacationtypeRepository->destroy($id);
    }

    /**
     * Get all vacationtype for droplist non permission
     *
     * @return JsonResponse
     */
    public function forExternalServices()
    {
        return $this->successResponse($this->vacationtypeRepository->forExternalServices(['id', 'name']));
    }

    /**
     * togglestatus the specified vacationtype.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->vacationtypeRepository->changeStatus($id);
    }
     /**
     * restore trashed vacationtype
     *
     * @return JsonResponse
     */
    public function restore($id)
    {
        return $this->vacationtypeRepository->restore($id);
    }
}
