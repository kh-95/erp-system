<?php

namespace App\Modules\Finance\Http\Repositories\Receipts;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Finance\Http\Repositories\Receipts\RecieptRepositoryInterface;
use App\Modules\Finance\Transformers\RecieptResource;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Entities\{Receipt,ReceiptAttachment};
use Illuminate\Support\Facades\DB;

class RecieptRepository extends CommonRepository implements RecieptRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'pay_status',
            'customer_type',
            'date',
            'certificate_number',
            'money',
            'cash_register',
            'management_id'
        ];
    }

    public function model()
    {
        return Receipt::class;
    }

    public function index(){
        $receipts = $this->setFilters()->with(['attachments', 'activities', 'receiptCustomer', 'receiptCustomerService', 'receiptCustomerAccount'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(RecieptResource::collection($receipts),$receipts);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('attachments','receiptCustomer','receiptCustomerService','receiptCustomerAccount')->toArray();
            $reciept = $this->create($Readydata);
            $this->storeRelations($data,$reciept);
            $load_relation = array();
            isset($data['receiptCustomer']) ? $load_relation[] = 'receiptCustomer': '';
            isset($data['receiptCustomerService']) ? $load_relation[] = 'receiptCustomerService': '';
            isset($data['receiptCustomerAccount']) ? $load_relation[] = 'receiptCustomerAccount': '';
            $load_relation[] = 'attachments';
            $load_relation[] = 'activities';
            $reciept->load($load_relation);

            return $this->successResponse(data: RecieptResource::make($reciept), message : trans('finance::messages.cashnotification.added_successfuly_record'));
        });
    }

    private function storeRelations($data, $reciept)
    {
        $load_relation = array();
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'receipt/attachments');
                return $data;
            })->values()->toArray();

            $reciept->attachments()->createMany($attachments);
        }
        isset($data['receiptCustomer']) ?
        $reciept->receiptCustomer()->create($data['receiptCustomer'])
        :'';
        isset($data['receiptCustomerService'])?
        $reciept->receiptCustomerService()->create($data['receiptCustomerService'])
        :'';
        isset($data['receiptCustomerAccount'])?
        $reciept->receiptCustomerAccount()->create($data['receiptCustomerAccount'])
        :'';

    }

    private function updateRelations($data, $reciept)
    {
        $load_relation = array();
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'receipt/attachments');
                return $data;
            })->values()->toArray();

            $reciept->attachments()->createMany($attachments);
        }
        isset($data['receiptCustomer']) ?
        $reciept->receiptCustomer()->update($data['receiptCustomer'])
        :'';
        isset($data['receiptCustomerService'])?
        $reciept->receiptCustomerService()->update($data['receiptCustomerService'])
        :'';
        isset($data['receiptCustomerAccount'])?
        $reciept->receiptCustomerAccount()->update($data['receiptCustomerAccount'])
        :'';
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = collect($data)->except('attachments','receiptCustomer','receiptCustomerService','receiptCustomerAccount')->toArray();
            $receipt = $this->update($Readydata, $id);
            $this->updateRelations($data,$receipt);
            $load_relation = array();
            isset($data['receiptCustomer']) ? $load_relation[] = 'receiptCustomer': '';
            isset($data['receiptCustomerService']) ? $load_relation[] = 'receiptCustomerService': '';
            isset($data['receiptCustomerAccount']) ? $load_relation[] = 'receiptCustomerAccount': '';
            $load_relation[] = 'attachments';
            $load_relation[] = 'activities';
            $receipt->load($load_relation);

            return $this->successResponse(data: RecieptResource::make($receipt), message : trans('finance::messages.cashnotification.edit_successfuly_record'));
        });
    }

    public function show($id)
    {
        try{
            $receipt = $this->find($id);
            $receipt->load(['attachments' ,'activities', 'receiptCustomer', 'receiptCustomerService', 'receiptCustomerAccount']);
            return $this->successResponse(data: RecieptResource::make($receipt));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = ReceiptAttachment::find($id);
            $this->deleteImage($attachment->file, 'receipt/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('finance::messages.receipt.remove_attachment_successfuly'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message: $exception->getMessage());
        }

    }


}
