<?php

namespace App\Modules\HR\Http\Repositories\Deduct;

use App\Modules\HR\Entities\DeductBonus;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\Deduct\DeductRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Foundation\Classes\Helper;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Requests\DeductRequest;
use App\Modules\HR\Transformers\DeductBounceResource;
use App\Modules\HR\Transformers\DeductResource;
use App\Modules\HR\Transformers\EmployeeResource;
use Spatie\QueryBuilder\AllowedFilter;
use App\Modules\HR\CustomSorts\BonusEmployeeNumberSort;
use App\Modules\HR\CustomSorts\BonusManagementSort;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Http\Requests\DeductStatusRequest;





class DeductRepository extends CommonRepository implements DeductRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
          'management_id',
          'employee_id',
          'employee.jobInformation.employee_number',
          'status',
          AllowedFilter::scope('create_from'),
          AllowedFilter::scope('create_to'),
          'action_type'

        ];
    }
    public function sortColumns()
    {
        return [
            'id',
            'created_at',
            'amount',
            'status',
            'action_type',
            'notes',
            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. DeductBonus::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. DeductBonus::getTableName().'.'.'management_id.name'),
            $this->sortUsingRelationship('employee-number',EmployeeJobInformation::getTableName().'.'. DeductBonus::getTableName().'.'.'employee_id.employee_number'),

        ];
    }
    public function model()
    {
        return DeductBonus::class;
    }


    public function store(DeductRequest $request)
    {
        return $this->create($request->validated() + ['type' => DeductBonus::DEDUCT, 'added_by_id' => auth()->id()]);
    }

    public function deductStatus(DeductStatusRequest $request, $id)
    {
        $row = $this->find($id);
        $row->update($request->validated());
        return $row;
    }

    public function updateDeduct(DeductRequest $request, $id)
    {
        $deduct = $this->find($id);
        $deduct->update($request->validated() + ['type' => DeductBonus::DEDUCT]);
        return $this->apiResource($deduct, true, __('Common::message.success_update') );
    }


    public function destroy($id)
    {
        $deduct =$this->find($id)->where('status','pending')->first();
        if ($deduct) {
            $this->delete($id);
            return $this->successResponse(['message' => __('hr::messages.general.successfully_deleted')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.deduct.deduct_not_in_pending_status')]);

     }

   public function getEmployeeByNumber($employee_number)
   {
        $employee = Employee::with('jobInformation','jobInformation.job.managment')->whereHas('jobInformation', function ($query) use($employee_number){
            $query->where('employee_number',$employee_number);
        })->first();
        return $this->apiResource(EmployeeResource::make($employee));

   }




}
