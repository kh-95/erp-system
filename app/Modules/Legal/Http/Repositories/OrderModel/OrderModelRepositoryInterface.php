<?php

namespace App\Modules\Legal\Http\Repositories\OrderModel;


use App\Modules\Legal\Http\Requests\OrderModelRequest;
use App\Repositories\CommonRepositoryInterface;
use Illuminate\Http\Request;

interface OrderModelRepositoryInterface extends CommonRepositoryInterface
{
    public function index(Request $request);
    public function store(OrderModelRequest $request);
    public function updateOrderModel(OrderModelRequest $request, $id);
    public function edit($id);
    public function show($id);
    public function destroy($id);
    public function deleteAttachmentOrder($id);
}
