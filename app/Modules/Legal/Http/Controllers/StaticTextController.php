<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\StaticText\StaticText;
use App\Modules\Legal\Http\Repositories\StaticText\StaticTextRepositoryInterface;
use App\Modules\Legal\Http\Requests\StaticTextRequest;
use App\Modules\Legal\Transformers\Agenecy\StaticTextResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StaticTextController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private StaticTextRepositoryInterface $staticTextRepository)
    {
        $this->middleware('permission:list-static_text')->only(['index']);
        $this->middleware('permission:create-static_text')->only(['store']);
        $this->middleware('permission:update-static_text')->only(['update']);
        $this->middleware('permission:delete-static_text')->only(['destroy']);
        $this->middleware('permission:show-static_text')->only(['show']);
    }

    public function index(Request $request)
    {
        $agenecies = $this->staticTextRepository
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->staticTextRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = StaticTextResource::collection($agenecies);

        return $this->paginateResponse($data, $agenecies);
    }

    public function store(StaticTextRequest $request)
    {
        $agenecy = $this->staticTextRepository->store($request);

        return $this->apiResource(StaticTextResource::make($agenecy), message: trans('legal::messages.general.successfully_created'));
    }

    public function show($id)
    {
        return StaticTextResource::make($this->staticTextRepository->show($id));
    }

    public function update(StaticTextRequest $request, $id)
    {
        $agenecyTerm = $this->staticTextRepository->updateAgenecyType($request, StaticText::findOrFail($id));

        return $this->apiResource(StaticTextResource::make($agenecyTerm), message: trans('legal::messages.general.successfully_updated'));
    }


    public function destroy($id)
    {
        $this->staticTextRepository->delete($id);

        return $this->successResponse(null, message: trans('legal::messages.general.successfully_deleted'));
    }
}
