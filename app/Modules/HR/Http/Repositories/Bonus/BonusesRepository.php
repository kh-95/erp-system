<?php

namespace App\Modules\HR\Http\Repositories\Bonus;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\CustomSorts\BonusEmployeeNumberSort;
use App\Modules\HR\CustomSorts\BonusManagementSort;
use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Http\Repositories\Bonus\BonusesRepositoryInterface;
use App\Modules\HR\Http\Requests\BonusRequest;
use App\Modules\HR\Http\Requests\BounsStatusRequest;
use App\Modules\HR\Transformers\BonusResource;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Http\Requests\BounsPaidRequest;
use Illuminate\Support\Carbon;


class BonusesRepository extends CommonRepository implements BonusesRepositoryInterface
{
    use ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'management_id',
            'employee_id',
            'employee.jobInformation.employee_number',
            AllowedFilter::scope('create_from'),
            AllowedFilter::scope('create_to'),
            AllowedFilter::scope('exchange_status'),
            'status'
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            'created_at',
            'amount',
            'status',
            'applicable_at',
            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. DeductBonus::getTableName().'.'.'employee_id.first_name'),
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. DeductBonus::getTableName().'.'.'management_id.name'),
            $this->sortUsingRelationship('employee-number',EmployeeJobInformation::getTableName().'.'. DeductBonus::getTableName().'.'.'employee_id.employee_number'),


        ];
    }




    public function model()
    {
        return DeductBonus::class;
    }


    public function store(BonusRequest $request)
    {
        return $this->create($request->validated() + ['type' => DeductBonus::BONUS, 'added_by_id' => auth()->id(), 'status' => 'pending', 'is_active' => 1]);
    }


    public function show($id)
    {
        return $this->findOrFail($id);
    }

    public function edit($id)
    {
        return $this->findOrFail($id);

    }

    public function updateBonus(BonusRequest $request, $id)
    {
        $bouns = $this->find($id);
        $bouns->update($request->validated());
        return $bouns;
    }

    public function bonusStatus(BounsStatusRequest $request, $id)
    {
        $bouns = $this->find($id);
        $bouns->update($request->validated());
        return $bouns;
    }

    public function bonusPaid(BounsPaidRequest $request, $id)
    {
        $bouns = $this->find($id);
        $request->paid == 1 ?  $bouns->update(['applicable_at'=> Carbon::now()]): "";
        return $bouns;
    }

    public function destroy($id)
    {
        $bouns =$this->find($id)->where('status','pending')->first();
        if ($bouns) {
            $this->delete($id);
            return $this->successResponse(['message' => __('hr::messages.general.successfully_deleted')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.bouns.bouns_not_in_pending_status')]);

     }

}
