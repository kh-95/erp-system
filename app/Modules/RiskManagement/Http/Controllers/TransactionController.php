<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Http\Repositories\Transaction\TransactionRepositoryInterface;
use App\Modules\RiskManagement\Transformers\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
    )
    {

//        $this->middleware('permission:transactions')->only(['index']);
//        $this->middleware('permission:show-transactions')->only(['show']);

    }

    public function index(Request $request)
    {
        $transactions = $this->transactionRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->transactionRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = TransactionResource::collection($transactions);

        return $this->paginateResponse($data, $transactions);
    }

    public function show($id)
    {
        $transaction = $this->transactionRepository->show($id);
        return $this->successResponse(TransactionResource::make($transaction));
    }
}
