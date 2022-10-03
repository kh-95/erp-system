<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\ExpenseTypeRequest;
use App\Modules\Finance\Http\Requests\ExpenseTypeUpdateRequest;
use App\Modules\Finance\Http\Repositories\ExpenseType\ExpenseTypeRepositoryInterface;
use App\Modules\Finance\Transformers\ExpenseTypeResource;
use App\Modules\Finance\Entities\ExpenseType;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class ExpenseTypeController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var ExpenseTypeRepository
     */
    private ExpenseTypeRepositoryInterface  $expensetypeRepository;
    /**
     * Create a new ExpenseTypeController instance.
     *
     * @param ExpenseTypeRepository $expensetypeRepository
     */
    public function __construct(ExpenseTypeRepositoryInterface $expensetypeRepository)
    {
        $this->expensetypeRepository = $expensetypeRepository;
        $this->middleware('permission:list-expensetype')->only(['index', 'show']);
        $this->middleware('permission:create-expensetype')->only(['store']);
        $this->middleware('permission:edit-expensetype')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-expensetype')->only(['destroy']);

    }

    /**
     * Get all expense types
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $types = $this->expensetypeRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = ExpenseTypeResource::collection($types);
        return $this->paginateResponse($data,$types);
    }

    /**
     * Create a expense types.
     *
     * @param ExpenseTypeRequest $request
     * @return JsonResponse
     */
    public function store(ExpenseTypeRequest $request): JsonResponse
    {
        return $this->expensetypeRepository->store($request);
    }

    /**
     * Show the specified expensetype.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        
        $type = $this->expensetypeRepository->find($id)->load('activities');
        return $this->successResponse(new ExpenseTypeResource($type));
    }
    /**
     * Show the specified type.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $type = $this->expensetypeRepository->find($id);
        return $this->successResponse(new ExpenseTypeResource($type));
    }

    /**
     * Update the specified type.
     *
     * @param ConstraitTypeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ExpenseTypeUpdateRequest $request, $id): JsonResponse
    {
        return $this->expensetypeRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->expensetypeRepository->destroy($id);
    }

    /**
     * togglestatus the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->expensetypeRepository->changeStatus($id);
    }

}
