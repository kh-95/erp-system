<?php

namespace App\Modules\HR\Http\Repositories\HoldHarmless;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\HoldHarmless\HoldHarmless;
use App\Modules\HR\Http\Requests\HoldHarmless\StoreRequest;

use App\Modules\HR\Transformers\HoldHarmless\HarmlessResource;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\HoldHarmless\HoldHarmlessRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HoldHarmlessRepository extends CommonRepository implements HoldHarmlessRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'mangement_id',
            'employee_id',
            'employees.identification_number',
            'employeejob.job_id',
            'employees.nationality_id',
            'status',
           'created_at'
        ];
    }
    public function sortColumns()
    {
        return [

            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. HoldHarmless::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('identification_number',Employee::getTableName().'.'. HoldHarmless::getTableName().'.'.'employee_id.identification_number'),
            $this->sortUsingRelationship('job-name',EmployeeJobInformation::getTableName().'.'. HoldHarmless::getTableName().'.'.'employee_id.job_id'),
            $this->sortUsingRelationship('nationality',Employee::getTableName().'.'. HoldHarmless::getTableName().'.'.'employee_id.nationality_id'),
            'status',
           'created_at'
        ];
    }





    public function model()
    {
        return HoldHarmless::class;
    }

    public function index(Request $request){
        $harmlessholds = $this->setFilters()->with(['employees'])
        ->defaultSort('-created_at')
        ->allowedSorts($this->sortColumns())
        ->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(HarmlessResource::collection($harmlessholds),$harmlessholds);
    }

    public function store($data)
    {
        return DB::transaction(function() use($data){
            $harmless = $this->create($data);
            $harmless->load('employees');

            return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_successfuly'));
        });
    }

    public function remove($id)
    {
      $harmless = $this->find($id);
      $harmless->delete();
      return $this->successResponse(trans('hr::messages.harmless.deleted_successfuly'));
    }

    public function storeStatusDM($data, $id)
    {
        $data['dm_response'] == 'accepted' && isset($data['dm_rejection_reason']) ? $data['dm_rejection_reason'] == null : '';
        $data['queue'] = 'dm';
        $harmless = $this->update($data, $id);
        $harmless->load('employees');
        return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_dm_successfuly'));

    }
    public function storeStatusHR($data, $id)
    {
        $data['hr_response'] == 'accepted' && isset($data['hr_rejection_reason']) ? $data['hr_rejection_reason'] == null : '';
        $data['queue'] = 'hr';
        $harmless = $this->update($data, $id);
        $harmless->load('employees');
        return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_hr_successfuly'));

    }

    public function storeStatusIT($data, $id){
        $data['it_response'] == 'accepted' && isset($data['it_rejection_reason']) ? $data['it_rejection_reason'] == null : '';
        $data['queue'] = 'it';
        $harmless = $this->update($data, $id);
        $harmless->load('employees');
        return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_it_successfuly'));
    }

    public function storeStatusLegal($data, $id){
        $data['legal_response'] == 'accepted' && isset($data['legal_rejection_reason']) ? $data['legal_rejection_reason'] == null : '';
        $data['queue'] = 'legal';
        $harmless = $this->update($data, $id);
        $harmless->load('employees');
        return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_legal_successfuly'));
    }

    public function storeStatusFinance($data, $id){
        $data['finance_response'] == 'accepted' && isset($data['finance_rejection_reason']) ? $data['finance_rejection_reason'] == null : '';
        $data['queue'] = 'finnce';
        $data['status'] = 1;
        $harmless = $this->update($data, $id);
        $harmless->load('employees');
        return $this->successResponse(data: new HarmlessResource($harmless), message : trans('hr::messages.harmless.added_finance_successfuly'));

    }

    public function show($id)
    {
        $harmless = $this->withTrashed()->find($id);
        return $this->successResponse(data: new HarmlessResource($harmless));
    }

    public function archive(Request $request){
        $harmlessholds = $this->setFilters()->with(['employees'])->withTrashed()->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(HarmlessResource::collection($harmlessholds),$harmlessholds);
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id)->restore();
        return $this->successResponse(['message' => __('hr::messages.harmless.restored_successfuly')]);
    }


}
