<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Repositories\Committee\CommitteeRepositoryInterface;
use App\Modules\Governance\Http\Requests\CommitteeRequest;
use App\Modules\Governance\Transformers\CommitteeResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommitteeController extends Controller
{

    use ApiResponseTrait;

    public function __construct(private CommitteeRepositoryInterface $committeeRepository)
    {
       $this->middleware('permission:list-committee')->only(['index']);
       $this->middleware('permission:create-committee')->only(['store']);
       $this->middleware('permission:update-committee')->only(['update','edit']);
       $this->middleware('permission:show-committee')->only(['show']);
       $this->middleware('permission:delete-committee')->only(['delete']);
    }

    public function index(Request $request)
    {
        $committees = $this->committeeRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->committeeRepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);
        $data = CommitteeResource::collection($committees);
        return $this->paginateResponse($data, $committees);
    }


    public function store(CommitteeRequest $request)
    {
        $committee = $this->committeeRepository->store($request);
        $data = CommitteeResource::make($committee);
        return $this->successResponse($data, message: trans('governance::messages.general.successfully_created'));
    }


    public function show($id)
    {
        $committee = $this->committeeRepository->show($id);
        return $this->successResponse(CommitteeResource::make($committee));
    }


    
    public function update(CommitteeRequest $request, $id)
    {
        $committee = $this->committeeRepository->updateCommittee($request, $id);
        $data = CommitteeResource::make($committee);
        return $this->successResponse($data, message: trans('governance::messages.general.successfully_updated'));
    }

    public function destroy($id)
    {
        return $this->committeeRepository->destroy($id);
    }



}
