<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Http\Repositories\Agenecy\AgenecyRepositoryInterface;
use App\Modules\Legal\Http\Requests\AgenecyRequest;
use App\Modules\Legal\Transformers\Agenecy\AgenecyResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AgenecyController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AgenecyRepositoryInterface $agenecyReopsitory)
    {
        $this->middleware('permission:list-agenecies')->only(['index']);
        $this->middleware('permission:create-agenecies')->only(['store']);
        $this->middleware('permission:update-agenecies')->only(['update']);
        $this->middleware('permission:delete-agenecies')->only(['destroy']);
        $this->middleware('permission:show-agenecies')->only(['show']);
    }

    public function index(Request $request)
    {
        $agenecies = $this->agenecyReopsitory
            ->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->agenecyReopsitory->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));

        $data = AgenecyResource::collection($agenecies);

        return $this->paginateResponse($data, $agenecies);
    }

    public function store(AgenecyRequest $request)
    {
        $agenecy = $this->agenecyReopsitory->store($request);

        return $this->apiResource(AgenecyResource::make($agenecy), message: trans('legal::messages.general.successfully_created'));
    }


    public function show($id)
    {
        return AgenecyResource::make($this->agenecyReopsitory->show($id));
    }

    public function update(AgenecyRequest $request, Agenecy $agenecy)
    {
        $agenecy = $this->agenecyReopsitory->updateAgenecy($request, $agenecy);

        return $this->apiResource(AgenecyResource::make($agenecy), message: trans('legal::messages.general.successfully_updated'));
    }
}
