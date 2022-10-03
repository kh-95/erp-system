<?php

namespace App\Modules\Finance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Finance\Http\Requests\ReceiptTypeRequest;
use App\Modules\Finance\Http\Requests\ReceiptTypeUpdateRequest;
use App\Modules\Finance\Http\Repositories\ReceiptType\ReceiptTypeRepositoryInterface;
use App\Modules\Finance\Transformers\ReceiptTypeResource;
use App\Modules\Finance\Entities\ReceiptType;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class ReceiptTypeController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var ReceiptTypeRepository
     */
    private ReceiptTypeRepositoryInterface  $receipttypeRepository;
    /**
     * Create a new ReceiptTypeController instance.
     *
     * @param ReceiptTypeRepository $receipttypeRepository
     */
    public function __construct(ReceiptTypeRepositoryInterface $receipttypeRepository)
    {
        $this->receipttypeRepository = $receipttypeRepository;
        $this->middleware('permission:list-receipttype')->only(['index', 'show']);
        $this->middleware('permission:create-receipttype')->only(['store']);
        $this->middleware('permission:edit-receipttype')->only(['update','togglestatus','edit']);
        $this->middleware('permission:delete-receipttype')->only(['destroy']);

    }

    /**
     * Get all expense types
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $types = $this->receipttypeRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = ExpenseTypeResource::collection($types);
        return $this->paginateResponse($data,$types);
    }

    /**
     * Create a expense types.
     *
     * @param ExpenseTypeRequest $request
     * @return JsonResponse
     */
    public function store(ReceiptTypeRequest $request): JsonResponse
    {
        return $this->receipttypeRepository->store($request);
    }

    /**
     * Show the specified expensetype.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        
        $type = $this->receipttypeRepository->find($id)->load('activities');
        return $this->successResponse(new ReceiptTypeResource($type));
    }
    /**
     * Show the specified type.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $type = $this->receipttypeRepository->find($id);
        return $this->successResponse(new ReceiptTypeResource($type));
    }

    /**
     * Update the specified type.
     *
     * @param ConstraitTypeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ReceiptTypeUpdateRequest $request, $id): JsonResponse
    {
        return $this->receipttypeRepository->updateaccount($request->validated(), $id);
    }

    /**
     * Remove the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->receipttypeRepository->destroy($id);
    }

    /**
     * togglestatus the specified type.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglestatus($id): JsonResponse
    {
        return $this->receipttypeRepository->changeStatus($id);
    }

}
