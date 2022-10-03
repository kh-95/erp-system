<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\Investigation\InvestigationRepositoryInterface;
use App\Modules\Legal\Http\Requests\Investigation\StoreInvestigationRequest;
use App\Modules\Legal\Http\Requests\Investigation\UpdateInvestigationRequest;
use App\Modules\Legal\Transformers\InvestigationResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvestigationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private InvestigationRepositoryInterface $InvestigationRepository)
    {
               $this->middleware('permission:list-investigations')->only(['index']);
               $this->middleware('permission:create-investigations')->only(['store']);
               $this->middleware('permission:edit-investigations')->only(['update','edit']);
               $this->middleware('permission:show-investigations')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $investigations = $this->InvestigationRepository->setFilters()->allowedIncludes('employee')
            ->defaultSort('-created_at')
            ->allowedSorts($this->InvestigationRepository->sortColumns())
            ->with(['asignedEmployee', 'management', 'employee'])
            ->paginate(Helper::getPaginationLimit($request));
        $data = InvestigationResource::collection($investigations);
        return $this->paginateResponse($data, $investigations);
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreInvestigationRequest $request
     * @return Renderable
     */
    public function store(StoreInvestigationRequest $request)
    {
        $data = $this->InvestigationRepository->store($request);
        return $this->apiResource(data: InvestigationResource::make($data), message: __('Common::message.success_create'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->InvestigationRepository->show($id);
        return $this->apiResource(InvestigationResource::make($data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->InvestigationRepository->edit($id);
        return $this->apiResource(data:InvestigationResource::make($data));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateInvestigationRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateInvestigationRequest $request, $id)
    {
        $data = $this->InvestigationRepository->updateInvestigation($request, $id);
        return $this->apiResource(data:InvestigationResource::make($data),message: __('Common::message.success_update'));
    }


}
