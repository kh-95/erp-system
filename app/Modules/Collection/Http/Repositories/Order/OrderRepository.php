<?php

namespace App\Modules\Collection\Http\Repositories\Order;

use App\Modules\Collection\Entities\{Order,OrderAttachment};
use App\Modules\TempApplication\Entities\Customer;
use App\Repositories\CommonRepository;
use App\Modules\Collection\Http\Repositories\Order\OrderRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Modules\Collection\Transformers\OrderResource;
use App\Foundation\Classes\Helper;

class OrderRepository extends CommonRepository implements OrderRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'order_no',
            'order_type',
            'order_date',
            $this->translated('order_subject'),
            $this->translated('order_text'),
            'customer_id',
            'customer_type',
            'mobile',
            'identity'
        ];
    }

    public function sortColumns()
    {

        return [
            'id',
            'order_no',
            'order_type',
            'order_date',
            $this->sortingTranslated('order_subject', 'order_subject'),
            $this->sortingTranslated('order_text', 'order_text'),
            'customer_id',
            'customer_type',
            'mobile',
            'identity'
        ];

    }

    public function model()
    {
        return Order::class;
    }

    public function index()
    {
        $orders = $this->setFilters()->defaultSort('-created_at')->with(['attachments', 'customer', 'activities'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(OrderResource::collection($orders),$orders);
    }

    public function store($data)
    {
        $Readydata = collect($data)->except('attachments')->toArray();
        $order = $this->create($Readydata);
        $this->storeRelations($data,$order);
        $order->load(['attachments', 'customer','activities']);
        return $this->successResponse(data: OrderResource::make($order), message : trans('collection::messages.order.add_successfuly'));
    }

    public function getCustomerByMobile($mobile){
        $customer = Customer::where('mobile', $mobile)->first();
        return $this->successResponse(data: CustomerResource::make($customer));
    }

    public function getCustomerByIdentity($identity){
        $customer = Customer::where('identity', $identity)->first();
        return $this->successResponse(data: CustomerResource::make($customer));
    }

    private function storeRelations($data, $order)
    {
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'orders/attachments');
                return $data;
            })->values()->toArray();

            $order->attachments()->createMany($attachments);
        }
    }

    public function edit($data, $id)
    {
        isset($data['attachments']) ?
        $Readydata = collect($data)->except('attachments')->toArray():
        $Readydata = collect($data)->except('')->toArray();
        $order = $this->update($Readydata, $id);
        $this->storeRelations($data,$order);
        $order->load(['attachments', 'customer','activities']);
        return $this->successResponse(data: OrderResource::make($order), message : trans('collection::messages.order.edit_successfuly'));
    }

    public function show($id)
    {
        try{
            $order = $this->find($id);
            $order->load(['attachments', 'customer']);
            return $this->successResponse(data: OrderResource::make($order));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = OrderAttachment::find($id);
            $this->deleteImage($attachment->file, 'orders/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('collection::messages.order.remove_attachment_successfuly'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message: $exception->getMessage());
        }

    }
}
