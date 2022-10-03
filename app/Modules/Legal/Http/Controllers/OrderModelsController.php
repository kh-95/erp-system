<?php

namespace App\Modules\Legal\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Http\Repositories\OrderModel\OrderModelRepositoryInterface;
use App\Modules\Legal\Http\Requests\OrderModelRequest;
use App\Modules\Legal\Transformers\OrderModelResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderModelsController extends Controller
{
    use ApiResponseTrait;

    private OrderModelRepositoryInterface $OrderModelRepository;

    public function __construct(OrderModelRepositoryInterface $OrderModelRepository)
    {
        $this->OrderModelRepository = $OrderModelRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        return $this->OrderModelRepository->index($request);
    }


    /**
     * Store a newly created resource in storage.
     * @param OrderModelRequest $request
     * @return Renderable
     */
    public function store(OrderModelRequest $request)
    {
       return $this->OrderModelRepository->store($request->validated());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->OrderModelRepository->show($id);

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return $this->OrderModelRepository->edit($id);
    }

    /**
     * Update the specified resource in storage.
     * @param OrderModelRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(OrderModelRequest $request, $id)
    {
        return $this->OrderModelRepository->updateOrderModel($request, $id);
    }

    public function destroy($id)
    {
        return $this->OrderModelRepository->destroy($id);
    }

    public function deleteAttachmentOrder($id)
    {
        return $this->OrderModelRepository->deleteAttachmentOrder($id);
    }
}
