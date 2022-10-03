<?php

namespace App\Modules\HR\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\HR\Transformers\Contracts\ContractClauseResource;
use App\Modules\HR\Http\Requests\Contracts\StoreContractClauseRequest;
use App\Modules\HR\Http\Requests\Contracts\updateContractClauseRequest;
use App\Modules\HR\Http\Repositories\Contracts\ContractClauseRepositoryInterface;

class ContractClauseController extends Controller
{
    use ApiResponseTrait;

    private ContractClauseRepositoryInterface  $contractClauseRepository;

    public function __construct(ContractClauseRepositoryInterface $contractClauseRepository)
    {
        $this->contractClauseRepository = $contractClauseRepository;
        $this->middleware('permission:list-contract_clause')->only(['index', 'show']);
        $this->middleware('permission:create-contract_clause')->only(['store']);
        $this->middleware('permission:edit-contract_clause')->only(['update']);
    }

   
    public function index(Request $request): JsonResponse
    {
        $contractClauses = $this->contractClauseRepository->setfilters()->paginate(Helper::getPaginationLimit($request));
        $data = ContractClauseResource::collection($contractClauses);
        return $this->paginateResponse($data, $contractClauses);
    }

    
    public function store(StoreContractClauseRequest $request): JsonResponse
    {
        try {
            $contractClause = $this->contractClauseRepository->create($request->validated());
            return $this->successResponse(new ContractClauseResource($contractClause));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        $contractClause = $this->contractClauseRepository->find($id);
        return $this->successResponse(new ContractClauseResource($contractClause));
    }

   
    public function update(updateContractClauseRequest $request, $id): JsonResponse
    {
        try {
            $this->contractClauseRepository->update($request->validated(), $id);
            $contractClause = $this->contractClauseRepository->find($id);
            return $this->successResponse(new ContractClauseResource($contractClause));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }
}
