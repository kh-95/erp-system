<?php

namespace App\Modules\HR\Http\Repositories\ServiceRequest;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\{ServiceResponse, ServiceResponseAttachment, ServiceRequest};
use App\Modules\HR\Transformers\ServiceResponseResource;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class ServiceResponseRepository extends CommonRepository implements ServiceResponseRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;
    protected function filterColumns(): array
    {

    }
    public function sortColumns()
    {

    }

    public function model()
    {
        return ServiceResponse::class;
    }

    public function replay($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = collect($data)->except('attachments')->toArray();
            $Readydata['service_request_id'] = $id;
            $service = $this->create($Readydata);
            $servicerequest = ServiceRequest::find($id);
            $servicerequest->status = 'responsed';
            $servicerequest->save();
            $this->storeRelations($data,$service);
            $service->load('attachments');
            return $this->successResponse(data:ServiceResponseResource::make($service), message : "Responsed");
        });
    }

    private function storeRelations($data, $service)
    {
        if(isset($data['attachments'])){
            $attachments = collect($data['attachments'])->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'services/attachments');
                return $data;
            })->values()->toArray();

            $service->attachments()->createMany($attachments);
        }
    }

    public function removeAttachment($id)
    {
        try{
            $attachment = ServiceResponseAttachment::find($id);
            $this->deleteImage($attachment->file, 'notification/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('finance::messages.notifaction.remove_attachment_successfuly_notification'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

}
