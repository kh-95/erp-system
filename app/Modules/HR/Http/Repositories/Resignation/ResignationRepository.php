<?php

namespace App\Modules\HR\Http\Repositories\Resignation;
use App\Foundation\Classes\Helper;
use App\Modules\HR\Entities\Resignation;
use App\Modules\HR\Entities\ResignationReason;
use App\Modules\HR\Entities\ResignationAttachment;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\ResignationResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\ResignationRequest;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\JobTranslation;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Http\Requests\ResignationupdateRequest;
use Illuminate\Support\Arr;
use App\Repositories\AttachesRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Spatie\QueryBuilder\AllowedFilter;

class ResignationRepository extends CommonRepository implements ResignationRepositoryInterface
{

    use ApiResponseTrait,ImageTrait;

    protected function filterColumns() :array
    {
        return [
            'employee_id',
            'job_id',
            'management_id',
            'identification_number',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
           //AllowedFilter::exact('management_id', null, 'management')
          // AllowedFilter::callback('management_id', fn (Builder $query) => $query->whereHas('management')),
        ];
    }

    public function sortColumns()
    {
        return [

            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. Resignation::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. Resignation::getTableName().'.'.'management_id.name'),
            $this->sortUsingRelationship('job-name',EmployeeJobInformation::getTableName().'.'. Resignation::getTableName().'.'.'job_id.name'),
            'created_at'
        ];
    }


    public function model()
    {
        return Resignation::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('hr::messages.resignation.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('hr::messages.resignation.toggle_successfuly')]);
    }
    public function store(resignationRequest $request)
    {
        $data = $request->validated();
        $resignation = $this->model()::make()->fill(Arr::except($data, ['attachments']));
        $resignation->save();
        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('resignation_attachments', $request, $resignation);
            $attaches->addAttaches();
        }
        $resignation->load('attachments');
        return $resignation;
        }


    public function storeRelations($request, $resignation)
    {
        $attachments = collect($request->attach)->map(function ($item, $key) {
            $data['attach'] =$this->storeImage($item, 'attachments');
            return $data;
        })->values()->toArray();
        $resignation->attachments()->createMany($attachments);
        $resignation->reasons()->createMany($request['reasons']);
    }
    public function updateRelations($request, $resignation)
    {
        if ($request->attach) {
            $attachments = collect($request->attach)->map(function ($item, $key) {
                $data['attach'] =$this->storeImage($item, 'attachments');
                return $data;
            })->values()->toArray();
            $resignation->attachments()->createMany($attachments);
            }

            if ($request->reason) {
                $resignation->reasons()->createMany($request['reason']);
            }
    }

    public function updateResignation(ResignationRequest $request,$id)
    {

       try {
        $resignation = $this->find($id);
        $data =$request->except(['employee_id','resignation_date','reason']);
        $data['employee_id'] = $request->employee_id;
        $data['resignation_date'] = $request->resignation_date;
        $resignation = $this->update($data, $id);
        $this->updateRelations($request, $resignation);
        return $this->apiResource(ResignationResource::make($resignation), true, __('Common::message.success_update'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
}
