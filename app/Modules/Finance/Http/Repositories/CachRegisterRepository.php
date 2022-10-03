<?php

namespace App\Modules\Finance\Http\Repositories;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Finance\Http\Repositories\CachRegisterRepositoryInterface;
use App\Modules\Finance\Transformers\CashRegisterResource;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Entities\{CashRegister,CashRegisterAttachments};
use Illuminate\Support\Facades\DB;

class CachRegisterRepository extends CommonRepository implements CachRegisterRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'tranfer_number',
            'date',
            'money',
            'from_register',
            'to_register',
            'bank_id',
            'check_number',
            'check_number_date',
        ];
    }

    public function model()
    {
        return CashRegister::class;
    }

    public function index(){
        $cashRegister = $this->setFilters()->with(['attachments', 'activities'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(CashRegisterResource::collection($cashRegister),$cashRegister);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('attachments')->toArray();
            $cashRegister = $this->create($Readydata);
            $this->storeRelations($data,$cashRegister);
            $cashRegister->load(['attachments' ,'activities']);
            $message = null;

            return $this->successResponse(data: CashRegisterResource::make($cashRegister), message : trans('finance::messages.cashnotification.added_successfuly_record'));
        });
    }

    private function storeRelations($data, $cashRegister)
    {
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'notification/attachments');
                return $data;
            })->values()->toArray();

            $cashRegister->attachments()->createMany($attachments);
        }
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = null;
            isset($data['attachments']) ?
            $Readydata = collect($data)->except('attachments')->toArray():
            $Readydata = $data;
            $cashRegister = $this->update($data, $id);
            $this->storeRelations($data,$cashRegister);
            $cashRegister->load(['attachments' ,'activities']);
            $message = null;

            return $this->successResponse(data: CashRegisterResource::make($cashRegister), message : trans('finance::messages.cashnotification.edit_successfuly_record'));
        });
    }

    public function show($id)
    {
        try{
            $cashRegister = $this->find($id);
            $cashRegister->load(['attachments' ,'activities']);
            return $this->successResponse(data: CashRegisterResource::make($cashRegister));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = CashRegisterAttachments::find($id);
            $this->deleteImage($attachment->file, 'notification/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('finance::messages.cashnotification.remove_attachment_successfuly_notification'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message:$exception->getMassege());
        }

    }


}
