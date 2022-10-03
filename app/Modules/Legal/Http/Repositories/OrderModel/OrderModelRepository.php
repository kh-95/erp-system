<?php

namespace App\Modules\Legal\Http\Repositories\OrderModel;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\FileTrait;
use App\Modules\Legal\Entities\Order;
use App\Modules\Legal\Entities\OrderAttachment;
use App\Modules\Legal\Http\Requests\OrderModelRequest;
use App\Repositories\CommonRepository;
use App\Modules\Legal\Transformers\OrderModelResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderModelRepository extends CommonRepository implements OrderModelRepositoryInterface
{
    use ApiResponseTrait, FileTrait;

    public function filterColumns()
    {
        return [
            'request_subject',
            'type',
            'request_date',
            'islamic_date'
        ];
    }

    public function sortColumns()
    {
        return [
            'request_subject',
            'type',
            'request_date',
            'islamic_date'

        ];
    }

    public function model()
    {
        return Order::class;
    }

    public function index(Request $request)
    {
        $model = $this->setFilters()->allowedIncludes('addedBy')
            ->defaultSort('-created_at')
            ->allowedSorts($this->sortColumns())
            ->with(['addedBy', 'management', 'employee', 'attachments' ,'consults' => function($q){
                $q->with('opinion');
            }])
            ->paginate(Helper::PAGINATION_LIMIT);

        $data = OrderModelResource::collection($model);
        return $this->paginateResponse($data, $model);
    }

    private function fileStore($files, $order_model)
    {
        foreach ($files as $file) {
            $attachment = explode('/', $file->getMimeType());
            $file_name = $this->storeFile($file, $attachment[0], Order::ORDER_MODEL);
            OrderAttachment::create(['media' => $file_name, 'order_id' => $order_model->id, 'type' => $this->baseByType($attachment[0])]);
        }
    }


    public function store($data)
    {
        $order = collect($data)->except('files')->toArray();
        $order_model = $this->create($order + ['type' => Order::MODELS, 'added_by_id' => auth()->id()]);
        $this->fileStore($data['files'], $order_model);
        $order_model->consults()->createMany($data['request_text']);
        $order_model->load('addedBy', 'management', 'employee', 'attachments', 'consults');
        $order_model->consults()->with('opinion');
        return $this->successResponse(data: OrderModelResource::make($order_model), message: __('common::message.success_create'));
    }


    public function show($id)
    {
        $order = $this->findOrFail($id)->load('addedBy', 'management', 'employee', 'attachments', 'consults');
        $order->consults()->with('opinion');
        return $this->successResponse(data: OrderModelResource::make($order));

    }

    public function edit($id)
    {
        $order = $this->findOrFail($id)->load('addedBy', 'management', 'employee', 'attachments', 'consults');
        $order->consults()->with('opinion');
        return $this->successResponse(data: OrderModelResource::make($order));

    }

    public
    function updateOrderModel($data, $id)
    {
        isset($data['files']) ?
        $order = collect($data)->except('files')->toArray():
        $order = collect($data)->except('')->toArray();

        $order_model = $this->find($id);
        if (isset($data['files'])) {
            $this->fileStore($data['files'], $order_model);
        }
        $order_model->update($order);
        isset($data['request_text']) ?
        $order_model->consults()->createMany($data['request_text']): '';
        $order_model->load('addedBy', 'management', 'employee', 'attachments', 'consults');
        $order_model->consults()->with('opinion');
        return $this->successResponse(data: OrderModelResource::make($order_model), message: __('common::message.success_create'));

    }

    public function destroy($id)
    {
        $files = $this->attachments();
        foreach ($files as $file) {
            $this->deleteFile($file->media, $file->type, Order::ORDER_MODEL);
        }
        $this->delete($id);
       return $this->successResponse(message: __('common.message.success_delete'));
    }

    public function deleteAttachmentOrder($id)
    {
        $file = OrderAttachment::find($id);
        $this->deleteFile($file->media, $file->type, Order::ORDER_MODEL);
        $file->delete();

        return $this->successResponse(message: __('common.message.success_delete'));

    }

}
