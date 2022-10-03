<?php

namespace App\Modules\Governance\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Repositories\CandidacyApplication\CandidacyApplicationRepositoryInterface;
use App\Modules\Governance\Http\Requests\CandidacyApplicationRequest;
use App\Modules\Governance\Transformers\CandidacyApplicationResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CandidacyApplicationController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private CandidacyApplicationRepositoryInterface  $candidacyRepository)
    {
        $this->candidacyRepository = $candidacyRepository;
        $this->middleware('permission:list-candidacy_application')->only(['index']);
        $this->middleware('permission:show-candidacy_application')->only(['show']);
        $this->middleware('permission:create-candidacy_application')->only(['store']);
        $this->middleware('permission:edit-candidacy_application')->only(['update']);
        $this->middleware('permission:delete-candidacy_application')->only(['destroy']);

    }
    public function index()
    {
        $candidacyApplications = $this->candidacyRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->candidacyRepository->sortColumns())
            ->with('attachments')
            ->paginate(Helper::PAGINATION_LIMIT);
        $data = CandidacyApplicationResource::collection($candidacyApplications);
        return $this->paginateResponse($data, $candidacyApplications);
    }


    public function store(CandidacyApplicationRequest $request)
    {
        $candidacy= $this->candidacyRepository->store($request);
        return $this->apiResource(
            CandidacyApplicationResource::make($candidacy),
            message: trans('governance::messages.general.successfully_created')
        );
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->candidacyRepository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return $this->candidacyRepository->edit($id);
    }


    public function update(CandidacyApplicationRequest $request, $candidacyRequest)
    {
        return $this->candidacyRepository->updateCandidacyRequset($request, $candidacyRequest);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->candidacyRepository->destroy($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }

    public function deleteAttachmentCandidacy($id)
    {
        $this->candidacyRepository->deleteAttachmentCandidacy($id);
        return $this->apiResource(message: __('Common.message.success_delete'));
    }
}
