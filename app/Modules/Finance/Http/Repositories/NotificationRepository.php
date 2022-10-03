<?php

namespace App\Modules\Finance\Http\Repositories;

use App\Foundation\Classes\Helper;
use App\Repositories\CommonRepository;
use App\Modules\Finance\Http\Repositories\NotificationRepositoryInterface;
use App\Modules\Finance\Transformers\NotificationResource;
use App\Foundation\Traits\ImageTrait;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Finance\Entities\{Notification,Attachment};
use Illuminate\Support\Facades\DB;

class NotificationRepository extends CommonRepository implements NotificationRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'id',
            'type',
            'way',
            'notification_number',
            'date',
            'management_id',
            'notification_name',
            'price',
            'complaint_number',
            'customer_id',
        ];
    }

    public function model()
    {
        return Notification::class;
    }

    public function index(){
        $notifications = $this->setFilters()->with(['attachments', 'activities'])->paginate(Helper::PAGINATION_LIMIT);
        return $this->paginateResponse(NotificationResource::collection($notifications),$notifications);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('attachments')->toArray();
            $notification = $this->create($Readydata);
            $this->storeRelations($data,$notification);
            $notification->load(['attachments' ,'activities']);
            $message = null;
            switch($Readydata['type']){
              case 'adding' : $message = trans('finance::messages.notifaction.added_add_successfuly_notification'); break;
              case 'equation' : $message = trans('finance::messages.notifaction.added_equation_successfuly_notification'); break;
              case 'discount' : $message = trans('finance::messages.notifaction.added_discount_successfuly_notification'); break;
            }
            return $this->successResponse(data: NotificationResource::make($notification), message : $message);
        });
    }

    private function storeRelations($data, $notification)
    {
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'notification/attachments');
                return $data;
            })->values()->toArray();

            $notification->attachments()->createMany($attachments);
        }
    }

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = null;
            isset($data['attachments']) ?
            $Readydata = collect($data)->except('attachments')->toArray():
            $Readydata = $data;
            $notification = $this->update($data, $id);
            $this->storeRelations($data,$notification);
            $notification->load(['attachments' ,'activities']);
            $message = null;
            switch($Readydata['type']){
              case 'adding' : $message = trans('finance::messages.notifaction.edit_add_successfuly_notification');
              case 'equation' : $message = trans('finance::messages.notifaction.edit_equation_successfuly_notification');
              case 'discount' : $message = trans('finance::messages.notifaction.edit_discount_successfuly_notification');
            }
            return $this->successResponse(data: NotificationResource::make($notification), message : $message);
        });
    }

    public function show($id)
    {
        try{
            $notification = $this->find($id);
            $notification->load(['attachments' ,'activities']);
            return $this->successResponse(data: NotificationResource::make($notification));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message: $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = Attachment::find($id);
            $this->deleteImage($attachment->file, 'notification/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('finance::messages.notifaction.remove_attachment_successfuly_notification'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }


}
