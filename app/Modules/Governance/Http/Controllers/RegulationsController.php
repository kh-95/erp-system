<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Repositories\Regulation\RegulationRepositoryInterface;
use App\Modules\Governance\Http\Requests\RegulationRequest;
use App\Modules\Governance\Transformers\RegulationResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegulationsController extends Controller
{
    use ApiResponseTrait;

    private RegulationRepositoryInterface $regulationRepository;

    public function __construct(RegulationRepositoryInterface $regulationRepository)
    {
        $this->regulationRepository = $regulationRepository;
        $this->middleware('permission:list-requlations')->only(['index']);
        $this->middleware('permission:show-requlations')->only(['show']);
        $this->middleware('permission:create-requlations')->only(['store']);
        $this->middleware('permission:edit-requlations')->only(['update']);
        $this->middleware('permission:delete-requlations')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $model = $this->regulationRepository->setFilters()->allowedIncludes('addedBy')
            ->defaultSort('-created_at')
            ->allowedSorts($this->regulationRepository->sortColumns())
            ->with(['addedBy', 'regulationAttachments'])
            ->paginate(Helper::PAGINATION_LIMIT);

        $data = RegulationResource::collection($model);
        return $this->paginateResponse($data, $model);
    }


    /**
     * Store a newly created resource in storage.
     * @param RegulationRequest $request
     * @return Renderable
     */
    public function store(RegulationRequest $request)
    {
        $data = $this->regulationRepository->store($request);
        return $this->apiResource(data: RegulationResource::make($data), message: __('Common::message.success_create'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->regulationRepository->show($id);
        return $this->apiResource(RegulationResource::make($data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->regulationRepository->edit($id);
        return $this->apiResource(data: RegulationResource::make($data));
    }

    /**
     * Update the specified resource in storage.
     * @param RegulationRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(RegulationRequest $request, $id)
    {
        $data = $this->regulationRepository->updateRegulation($request, $id);
        return $this->apiResource(data: RegulationResource::make($data), message: __('Common::message.success_update'));
    }

    public function destroy($id)
    {
        $this->regulationRepository->destroy($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }

    public function deleteAttachmentRegulation($id)
    {
        $this->regulationRepository->deleteAttachmentRegulation($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }
}
