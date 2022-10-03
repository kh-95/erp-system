<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\BlackList;
use App\Modules\HR\Http\Repositories\Employee\BlackListRepositoryInterface;
use App\Modules\HR\Http\Requests\Employee\BlackListRequest;
use App\Modules\HR\Transformers\BlackList\BlackListResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlackListController extends Controller
{

    use ApiResponseTrait;
    public function __construct(private BlackListRepositoryInterface $blackListRepository)
    {
        $this->blackListRepository = $blackListRepository;
        $this->middleware('permission:list-blacklist')->only('index');
        $this->middleware('permission:blacklist')->only(['show']);
        $this->middleware('permission:create-blacklist')->only('store');
        $this->middleware('permission:edit-blacklist')->only('update');
        $this->middleware('permission:delete-blacklist')->only('destroy');
    }

    public function index(Request $request)
    {
        $blackLists = $this->blackListRepository->setFilters()
            ->defaultSort('-created_at')
            ->allowedSorts($this->blackListRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = BlackListResource::collection($blackLists);
        return $this->paginateResponse($data, $blackLists);
    }

    public function store(BlackListRequest $request)
    {
        return $this->blackListRepository->store($request);
    }

    public function show($id){
        return $this->blackListRepository->show($id);
    }

    public function activities($id)
    {
        return $this->blackListRepository->recordActivities($id);
    }

    public function edit($id){
        return $this->blackListRepository->edit($id);
    }
    public function update(BlackListRequest $request, $blackList){
        return $this->blackListRepository->updateBlackList($request, $blackList);
    }

    public function destroy($id)
    {
        return $this->blackListRepository->destroy($id);
    }

}
