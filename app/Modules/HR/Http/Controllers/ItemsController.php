<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Repositories\Item\ItemRepositoryInterface;
use App\Modules\HR\Http\Requests\ItemRequest;
use App\Modules\HR\Transformers\ItemResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ItemsController extends Controller
{
    use ApiResponseTrait;

    private ItemRepositoryInterface $ItemRepository;

    public function __construct(ItemRepositoryInterface $ItemRepository)
    {
        $this->ItemRepository = $ItemRepository;
        $this->middleware('permission:list-hr_item')->only('index');
        $this->middleware('permission:create-hr_item')->only('store');
        $this->middleware('permission:edit-hr_item')->only('update');
        $this->middleware('permission:show-hr_item')->only('show');
        $this->middleware('permission:delete-hr_item')->only('destroy');

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $Item = $this->ItemRepository->setFilters()->allowedIncludes('addedBy')
            ->defaultSort('-created_at')
            ->allowedSorts($this->ItemRepository->sortColumns())
            ->with(['addedBy'])
            ->paginate(Helper::getPaginationLimit($request));

        $data = ItemResource::collection($Item);
        return $this->paginateResponse($data, $Item);
    }


    /**
     * Store a newly created resource in storage.
     * @param ItemRequest $request
     * @return Renderable
     */
    public function store(ItemRequest $request)
    {
        $data = $this->ItemRepository->store($request);
        return $this->apiResource(data: ItemResource::make($data), message: __('Common::message.success_create'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->ItemRepository->show($id);
        return $this->apiResource(ItemResource::make($data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->ItemRepository->edit($id);
        return $this->apiResource(data:ItemResource::make($data));
    }

    /**
     * Update the specified resource in storage.
     * @param ItemRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(ItemRequest $request, $id)
    {
        $data = $this->ItemRepository->updateInterviewItem($request, $id);
        return $this->apiResource(data:ItemResource::make($data),message: __('Common::message.success_update'));
    }

    public function destroy($id)
    {
        $this->ItemRepository->destroy($id);
        return $this->apiResource(message:__('Common.message.success_delete'));
    }
}
