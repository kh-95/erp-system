<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\CompanyCase\CompanyCaseRepositoryInterface;
use App\Modules\Legal\Http\Requests\CompanyCaseRequest;
use App\Modules\Legal\Transformers\CompanyCaseResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyCaseController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private CompanyCaseRepositoryInterface $companyCaseRepository,
    )
    {
//        $this->middleware('permission:list-company_cases')->only(['index']);
//        $this->middleware('permission:create-company_cases')->only(['store']);
//        $this->middleware('permission:edit-company_cases')->only(['update']);
//        $this->middleware('permission:show-company_cases')->only(['show']);
//        $this->middleware('permission:delete-company_cases')->only(['delete']);
    }

    public function index(Request $request)
    {
        $companyCases = $this->companyCaseRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->companyCaseRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = CompanyCaseResource::collection($companyCases);

        return $this->paginateResponse($data, $companyCases);
    }


    public function store(CompanyCaseRequest $request)
    {
        $case = $this->companyCaseRepository->store($request);
        $data = CompanyCaseResource::make($case);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_created'));
    }


    public function show($id)
    {
        $case = $this->companyCaseRepository->show($id);
        return $this->successResponse(CompanyCaseResource::make($case));
    }


    public function update(CompanyCaseRequest $request, $id)
    {
        $case = $this->companyCaseRepository->updateCompanyCase($request,$id);
        $data = CompanyCaseResource::make($case);
        return $this->successResponse($data, message: trans('legal::messages.general.successfully_updated'));
    }


    public function destroy($id)
    {
        $case = $this->model()::findOrFail($id);
        $case->delete();
        return $this->successResponse($case, message: trans('legal::messages.general.successfully_deleted'));
    }

}
