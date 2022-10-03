<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use Illuminate\Routing\Controller;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Requests\StrategicPlanRequest;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Transformers\StrategicPlan\StrategicPlanResource;
use App\Modules\Governance\Transformers\StrategicPlan\StrategicPlanShowResource;
use App\Modules\Governance\Http\Repositories\StrategicPlan\StrategicPlanRepositoryInterface;

class StrategicPlanController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private StrategicPlanRepositoryInterface $strategicPlanRepository)
    {
        $this->middleware('permission:list-strategic-plans')->only(['index']);
        $this->middleware('permission:create-strategic-plans')->only(['store']);
        $this->middleware('permission:edit-strategic-plans')->only(['update']);
        $this->middleware('permission:delete-strategic-plans')->only(['destroy']);
        $this->middleware('permission:show-strategic-plans')->only(['show']);
    }

    public function index()
    {
        $strategicplans = $this->strategicPlanRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->strategicPlanRepository->sortColumns())
            ->paginate(Helper::PAGINATION_LIMIT);

        $data = StrategicPlanResource::collection($strategicplans);

        return $this->paginateResponse($data, $strategicplans);
    }

    public function store(StrategicPlanRequest $request)
    {
        $strategicPlan = $this->strategicPlanRepository->store($request);

        return $this->apiResource(StrategicPlanShowResource::make($strategicPlan), message: trans('governance::messages.general.successfully_created'));
    }

    public function show($id)
    {
        return StrategicPlanShowResource::make($this->strategicPlanRepository->show($id));
    }

    public function update(StrategicPlanRequest $request, StrategicPlan $strategicPlan)
    {
        $strategicPlan = $this->strategicPlanRepository->updateStrategicPlan($request, $strategicPlan);

        return $this->apiResource(StrategicPlanShowResource::make($strategicPlan), message: trans('governance::messages.general.successfully_updated'));
    }

    public function destroy($id)
    {
        $this->strategicPlanRepository->destroy($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }

}
