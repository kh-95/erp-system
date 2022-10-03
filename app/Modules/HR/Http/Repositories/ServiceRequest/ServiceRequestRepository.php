<?php

namespace App\Modules\HR\Http\Repositories\ServiceRequest;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\{ServiceRequest,ServiceReqAttach};
use App\Modules\HR\Http\Requests\ServiceRrequest\ValidateServiceRequest;
use App\Modules\HR\Transformers\ServiceRequestResource;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class ServiceRequestRepository extends CommonRepository implements ServiceRequestRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;
    protected function filterColumns(): array
    {
        return [
            'id',
            'management.name',
            'employee.first_name',
            'employee.second_name',
            'employee.third_name',
            'employee.last_name',
            'service_type',
            'directed_to',
            'status',
            'created_at'
        ];
    }
    public function sortColumns()
    {
        return [
            'service_type',
            'directed_to',
            'status',

        ];
    }

    public function model()
    {
        return ServiceRequest::class;
    }

    public function index(){
        $service_requests = $this->setFilters()->allowedIncludes(['employee','management'])
            ->defaultSort('-created_at')
            ->allowedSorts('id',
            'management.name',
            'employee.first_name',
            'employee.second_name',
            'employee.third_name',
            'employee.last_name',
            'service_type',
            'directed_to',
            'status',
            'created_at')
            ->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(ServiceRequestResource::collection($service_requests),$service_requests);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $Readydata = collect($data)->except('attachments')->toArray();
            $Readydata['status'] = 'sent';
            $Readydata['user_id'] = \Auth::user()->id;
            $service = $this->create($Readydata);
            $this->storeRelations($data,$service);
            $service->load(['attachments' ,'activities', 'management', 'employee']);

            return $this->successResponse(data: ServiceRequestResource::make($service), message : trans('hr::messages.service.added_successfuly'));
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

    public function edit($data, $id)
    {
        return DB::transaction(function() use($data, $id){
            $Readydata = null;
            isset($data['attachments']) ?
            $Readydata = collect($data)->except('attachments')->toArray():
            $Readydata = $data;
            $service = $this->update($data, $id);
            $this->storeRelations($data,$notification);
            $service->load(['attachments' ,'activities', 'management', 'employee']);
            $message = null;

            return $this->successResponse(data: ServiceRequestResource::make($service), message : trans('hr::messages.service.edit_successfuly'));
        });
    }

    public function show($id)
    {
        try{
            $service = $this->find($id);
            if(\Auth::user()->id == $service->user_id && $service->status != 'responsed'){
                $service->status = 'waiting';
                $service->save;
            }elseif(\Auth::user()->id != $service->user_id && $service->status != 'responsed'){
                $service->status = 'show';
                $service->save;
            }
            $service->load(['attachments' , 'management', 'employee', 'serviceresponse']);
            return $this->successResponse(data: ServiceRequestResource::make($service));
        }catch(\Exception $exception){
            return $this->errorResponse(null, message: $exception->getMassege());
        }

    }

    public function removeAttachment($id)
    {
        try{
            $attachment = ServiceReqAttach::find($id);
            $this->deleteImage($attachment->file, 'notification/attachments');
            $attachment->delete();
            return $this->successResponse( message : trans('hr::messages.service.remove_attachment_successfuly'));
        }catch(\Exception $exception){
            return $this->errorResponse(null, $exception->getMassege());
        }

    }

    public function editService($id)
    {
        $service_request = $this->find($id);
        $service_request->load(['attachments', 'management', 'employee']);
        return $this->successResponse(data: ServiceRequestResource::make($service_request));
    }
}
