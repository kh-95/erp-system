<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Entities\Succession;
use App\Modules\Governance\Http\Repositories\Succession\SuccessionRepositoryInterface;
use App\Modules\Governance\Http\Requests\SuccessionRequest;
use App\Modules\Governance\Transformers\SuccessionResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SuccessionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private SuccessionRepositoryInterface $successionRepository)
    {
//        $this->middleware('permission:list-succession')->only(['index']);
//        $this->middleware('permission:create-succession')->only(['store']);
//        $this->middleware('permission:update-succession')->only(['update']);
//        $this->middleware('permission:show-succession')->only(['show']);
//        $this->middleware('permission:delete-succession')->only(['delete']);
    }

    public function index(Request $request)
    {

        $successions = $this->successionRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->successionRepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);
        $data = SuccessionResource::collection($successions);
        return $this->paginateResponse($data, $successions);
    }

    public function store(SuccessionRequest $request)
    {
        $successions = $this->successionRepository->store($request);
        $data = SuccessionResource::make($successions);
        return $this->successResponse($data, message: trans('governance::messages.general.successfully_created'));
    }


    public function show($id)
    {
        $successions = $this->successionRepository->show($id);
        return $this->successResponse(SuccessionResource::make($successions));
    }


    public function update(SuccessionRequest $request, $id)
    {
        $successions = $this->successionRepository->updateSuccession($request, $id);
        $data = SuccessionResource::make($successions);
        return $this->successResponse($data, message: trans('governance::messages.general.successfully_updated'));
    }

    
    public function destroy($id)
    {
        return $this->successionRepository->destroy($id);
    }
}
