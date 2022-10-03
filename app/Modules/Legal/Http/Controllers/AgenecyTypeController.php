<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Http\Repositories\AgenecyType\AgenecyTypeRepositoryInterface;
use App\Modules\Legal\Http\Requests\AgenecyTypeRequest;
use App\Modules\Legal\Transformers\Agenecy\AgenecyTypeResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AgenecyTypeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AgenecyTypeRepositoryInterface $agenecyTypeRepository)
    {
        $this->middleware('permission:list-agenecy_types')->only(['index']);
        $this->middleware('permission:create-agenecy_types')->only(['store']);
        $this->middleware('permission:update-agenecy_types')->only(['update']);
        $this->middleware('permission:delete-agenecy_types')->only(['destroy']);
        $this->middleware('permission:show-agenecy_types')->only(['show']);
    }

    public function index(Request $request)
    {
        $agenecies = $this->agenecyTypeRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->agenecyTypeRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = AgenecyTypeResource::collection($agenecies);

        return $this->paginateResponse($data, $agenecies);
    }

    public function store(AgenecyTypeRequest $request)
    {
        $agenecy = $this->agenecyTypeRepository->store($request);

        return $this->apiResource(AgenecyTypeResource::make($agenecy), message: trans('legal::messages.general.successfully_created'));
    }

    public function show($id)
    {
        return AgenecyTypeResource::make($this->agenecyTypeRepository->show($id));
    }

    public function update(AgenecyTypeRequest $request, AgenecyType $agenecyType)
    {
        $agenecyTerm = $this->agenecyTypeRepository->updateAgenecyType($request, $agenecyType);

        return $this->apiResource(AgenecyTypeResource::make($agenecyTerm), message: trans('legal::messages.general.successfully_updated'));
    }


    public function destroy($id)
    {
        $this->agenecyTypeRepository->delete($id);

        return $this->successResponse(null, message: trans('legal::messages.general.deleted_successfuly'));
    }
}
