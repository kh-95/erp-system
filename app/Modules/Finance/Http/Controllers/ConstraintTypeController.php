<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\ConstraintTypeRequest;
use App\Modules\Finance\Http\Requests\ConstraintTypeUpdateRequest;
use App\Modules\Finance\Http\Repositories\ConstraintType\ConstraintTypeRepositoryInterface;
use App\Modules\Finance\Transformers\ConstraintTypeResource;
use App\Modules\Finance\Entities\ConstraintType;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class ConstraintTypeController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var AConstraintTypeRepository
     */
    private ConstraintTypeRepositoryInterface  $constrainttypeRepository;
    /**
     * Create a new AssetCategoryController instance.
     *
     * @param ConstraintTypeRepository $constrainttypeRepository
     */
    public function __construct(ConstraintTypeRepositoryInterface $constrainttypeRepository)
    {
        $this->constrainttypeRepository = $constrainttypeRepository;
        $this->middleware('permission:list-constrainttype')->only(['index', 'show']);
        $this->middleware('permission:create-constrainttype')->only(['store']);
        $this->middleware('permission:edit-constrainttype')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-constrainttype')->only(['destroy']);

    }

    /**
     * Get all constraint types
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $types = $this->constrainttypeRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = ConstraintTypeResource::collection($types);
        return $this->paginateResponse($data,$types);
    }

    /**
     * Create a constraint types.
     *
     * @param ConstraintTypeRequest $request
     * @return JsonResponse
     */
    public function store(ConstraintTypeRequest $request): JsonResponse
    {
        return $this->constrainttypeRepository->store($request);
    }

    /**
     * Show the specified constrainttype.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        
        $type = $this->constrainttypeRepository->find($id)->load('activities');
        return $this->successResponse(new ConstraintTypeResource($type));
    }
    /**
     * Show the specified type.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $type = $this->constrainttypeRepository->find($id);
        return $this->successResponse(new ConstraintTypeResource($type));
    }

    /**
     * Update the specified type.
     *
     * @param ConstraitTypeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ConstraintTypeUpdateRequest $request, $id): JsonResponse
    {
        return $this->constrainttypeRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->constrainttypeRepository->destroy($id);
    }

    /**
     * togglestatus the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->constrainttypeRepository->changeStatus($id);
    }

}
