<?php

namespace App\Modules\CustomerService\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Http\Repositories\Call\CallRepositoryInterface;
use App\Modules\CustomerService\Http\Requests\ConvertCallRequest;
use App\Modules\CustomerService\Transformers\CallResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CallController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private CallRepositoryInterface $callRepository
    ) {
        $this->middleware('permission:list-calls')->only(['index']);
        $this->middleware('permission:list-convertCall')->only(['convertCall']);
    }

    public function index(Request $request)
    {
        $calls = $this->callRepository
            ->setFilters()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->defaultSort('-created_at')
            ->allowedSorts($this->callRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = CallResource::collection($calls);

        return $this->paginateResponse($data, $calls);
    }

    public function convertCall(ConvertCallRequest $request, Call $call)
    {
        $call =  $this->callRepository->convertCall($request, $call);

        return $this->apiResource(CallResource::make($call), message: trans('customerservice::messages.general.successfully_converted'));
    }
}
