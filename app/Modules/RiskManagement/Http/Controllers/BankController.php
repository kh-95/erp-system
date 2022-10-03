<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Http\Repositories\Bank\BankRepositoryInterface;
use App\Modules\RiskManagement\Http\Requests\BankRequest;
use App\Modules\RiskManagement\Transformers\BankResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BankController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private BankRepositoryInterface $bankRepository)
    {
       $this->middleware('permission:list-banks')->only(['index']);
       $this->middleware('permission:create-banks')->only(['store']);
       $this->middleware('permission:edit-banks')->only(['update']);
       $this->middleware('permission:show-banks')->only(['show']);
       $this->middleware('permission:destroy-banks')->only(['destroy']);

     }

    public function index(Request $request)
    {
        $bank = $this->bankRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->bankRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = BankResource::collection($bank);

        return $this->paginateResponse($data, $bank);
    }


    public function store(BankRequest $request)
    {
        $bank = $this->bankRepository->store($request);
        $data = BankResource::make($bank);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_created'));
    }


    public function show($id)
    {
        $bank = $this->bankRepository->show($id);
        return $this->successResponse(BankResource::make($bank));
    }


    public function update(BankRequest $request, $id)
    {
        $bank = $this->bankRepository->updateBank($request,$id);
        $data = BankResource::make($bank);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_updated'));
    }

    public function destroy($id)
    {   //TODO:: //check if place has meetings
        $this->bankRepository->delete($id);
        return $this->successResponse(null, message: trans('legal::messages.general.deleted_successfuly'));
    }

    public function listBanks()
    {
        return $this->successResponse($this->bankRepository->listBanks());
    }
}
