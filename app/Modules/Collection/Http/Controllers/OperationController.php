<?php

namespace App\Modules\Collection\Http\Controllers;

use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Collection\Http\Repositories\OperationRepositoryInterface;
use App\Modules\Collection\Transformers\OperationResource;


class OperationController extends Controller
{
    use ApiResponseTrait;


    public function __construct(OperationRepositoryInterface $operationRepository)
    {
        $this->operationRepository = $operationRepository;
        $this->middleware('permission:list-operation')->only(['index']);
        $this->middleware('permission:show-operation')->only(['show']);
    }

    public function index(Request $request)
    {
            $operations = $this->operationRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->operationRepository->sortColumns())
            ->with(['activities'])
            ->paginate(Helper::PAGINATION_LIMIT);
        $data = OperationResource::collection($operations);
        return $this->paginateResponse($data, $operations);
    }


    public function show($id)
    {
        $operation = $this->operationRepository->show($id);
        return $this->successResponse(OperationResource::make($operation));
    }



}
