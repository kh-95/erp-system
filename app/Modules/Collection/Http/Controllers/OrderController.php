<?php

namespace App\Modules\Collection\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Collection\Http\Requests\OrderRequest;
use App\Modules\Collection\Http\Repositories\Order\OrderRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Collection\Http\Repositories\OrderAttachment\OrderAttachmentRepositoryInterface;
use App\Modules\Collection\Http\Requests\StoreAttachementsRequest;
use App\Modules\Collection\Transformers\OrderResource;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponseTrait ,ImageTrait;
    protected orderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->middleware('permission:list-collection_order')->only(['index', 'show']);
        $this->middleware('permission:create-collection_order')->only('store');
        $this->middleware('permission:edit-collection_order')->only('update');
        $this->middleware('permission:remove_attachment-collection_order')->only('removeAttachment');
    }

    public function index(Request $request): JsonResponse
    {
       return $this->orderRepository->index($request);
    }

    public function store(OrderRequest $request)
    {
       return  $this->orderRepository->store($request->validated());
    }

    public function show($id)
    {
        return $this->orderRepository->show($id);
    }

    public function update(OrderRequest $request, $id): JsonResponse
    {
        return $this->orderRepository->edit($request->validated(), $id);
    }

    public function removeAttachment($id){
        return $this->orderRepository->removeAttachment($id);
    }

    public function activities($id)
    {
        return $this->orderRepository->recordActivities($id);
    }

    public function getCustomerByMobile($mobile)
    {
        return $this->orderRepository->getCustomerByMobile($mobile);
    }

    public function getCustomerByIdentity($identity)
    {
        return $this->orderRepository->getCustomerByIdentity($identity);
    }
}
