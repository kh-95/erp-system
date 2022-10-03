<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Http\Repositories\AgenecyTerm\AgenecyTermRepositoryInterface;
use App\Modules\Legal\Http\Requests\AgenecyTermRequest;
use App\Modules\Legal\Transformers\Agenecy\AgenecyTermResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AgenecyTermController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AgenecyTermRepositoryInterface $agenecyTermRepository)
    {
        $this->middleware('permission:list-agenecy_terms')->only(['index']);
        $this->middleware('permission:create-agenecy_terms')->only(['store']);
        $this->middleware('permission:update-agenecy_terms')->only(['update']);
        $this->middleware('permission:delete-agenecy_terms')->only(['destroy']);
        $this->middleware('permission:show-agenecy_terms')->only(['show']);
    }

    public function index(Request $request)
    {
        $agenecies = $this->agenecyTermRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->agenecyTermRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = AgenecyTermResource::collection($agenecies);

        return $this->paginateResponse($data, $agenecies);
    }

    public function store(AgenecyTermRequest $request)
    {
        $agenecy = $this->agenecyTermRepository->store($request);

        return $this->apiResource(AgenecyTermResource::make($agenecy), message: trans('legal::messages.general.successfully_created'));
    }

    public function show($id)
    {
        return AgenecyTermResource::make($this->agenecyTermRepository->show($id));
    }

    public function update(AgenecyTermRequest $request, AgenecyTerm $agenecyTerm)
    {
        $agenecyTerm = $this->agenecyTermRepository->updateAgenecyTerm($request, $agenecyTerm);

        return $this->apiResource(AgenecyTermResource::make($agenecyTerm), message: trans('legal::messages.general.successfully_updated'));
    }


    public function destroy($id)
    {
        $this->agenecyTermRepository->delete($id);

        return $this->successResponse(null, message: trans('legal::messages.general.deleted_successfuly'));
    }
}
