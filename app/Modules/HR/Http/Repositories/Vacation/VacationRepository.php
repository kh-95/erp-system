<?php

namespace App\Modules\HR\Http\Repositories\Vacation;

use App\Foundation\Classes\Helper;
use App\Modules\HR\CustomSorts\VacationManagementSort;
use App\Modules\HR\CustomSorts\VacationTypeNameSort;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Vacation;
use App\Modules\HR\Entities\VacationType;
use App\Modules\HR\Entities\VacationAttachment;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\VacationResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\VacationRequest;
use App\Foundation\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class VacationRepository extends CommonRepository implements VacationRepositoryInterface
{

    use ApiResponseTrait, ImageTrait;

    protected function filterColumns(): array
    {
        return [
            'employeeOfVacation.jobInformation.job.management.id',
            'vacation_employee_id',
            'vacation_type_id',
            'deactivated_at',
            AllowedFilter::scope('from'),
            AllowedFilter::scope('to'),
            'alter_employee_id',
            'id'
        ];
    }


    public function sortColumns()
    {
        return [

            'id',
            $this->sortUsingRelationship('vacation-employee-name', Employee::getTableName() . '.' . Vacation::getTableName() . '.' . 'vacation_employee_id.first_name'),
            AllowedSort::custom('management-name', new VacationManagementSort(), 'name'),
            'vacation_from_date',
            'vacation_to_date',
            AllowedSort::custom('vacation-type-name', new VacationTypeNameSort(), 'name'),

        ];
    }

    public function model()
    {
        return Vacation::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message' => __('hr::messages.vacation.deleted_successfuly')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
        $this->toggleStatus($id);
        return $this->successResponse(['message' => __('hr::messages.vacation.toggle_successfuly')]);
    }


    public function store(VacationRequest $request)
    {
        try {
            $data = $request->except(['vacation_employee_id', 'vacation_type_id', 'number_days', 'vacation_from_date', 'vacation_to_date', 'alter_employee_id']);
            $data['vacation_employee_id'] = $request->vacation_employee_id;
            $data['vacation_type_id'] = $request->vacation_type_id;
            $data['number_days'] = $request->number_days;
            $data['vacation_from_date'] = $request->vacation_from_date;
            $data['vacation_to_date'] = $request->vacation_to_date;
            $data['alter_employee_id'] = $request->alter_employee_id;
            $vacation = $this->create($data);

            $attachments = collect($request->attach)->map(function ($item, $key) {
                $data['attach'] = $this->storeImage($item, 'attachments');
                return $data;
            })->values()->toArray();
            $vacation->attachments()->createMany($attachments);
            return $this->successResponse(new VacationResource($vacation), true, __('hr::messages.vacation.create_successfuly'));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }


    public function updatevacation($request, $id)
    {
        try {
            $vacation = $this->find($id);
            $data = $request->except(['vacation_employee_id', 'vacation_type_id', 'number_days', 'vacation_from_date', 'vacation_to_date', 'alter_employee_id']);
            $data['vacation_employee_id'] = $request->vacation_employee_id;
            $data['vacation_type_id'] = $request->vacation_type_id;
            $data['number_days'] = $request->number_days;
            $data['vacation_from_date'] = $request->vacation_from_date;
            $data['vacation_to_date'] = $request->vacation_to_date;
            $data['alter_employee_id'] = $request->alter_employee_id;
            $vacation = $this->update($data, $id);
            if ($request->attach) {
                $attachments = collect($request->attach)->map(function ($item, $key) {
                    $data['attach'] = $this->storeImage($item, 'attachments');
                    return $data;
                })->values()->toArray();
                $vacation->attachments()->createMany($attachments);
            }
            return $this->successResponse(new VacationResource($vacation), true, __('hr::messages.vacation.update_successfuly'));
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    public function calculatebalance($employee_id, $type_id)
    {
        $balance = $this->findWhere(['vacation_employee_id' => $employee_id,
            'vacation_type_id' => $type_id,
        ])
            ->WhereNotNull('deactivated_at')->sum('number_days');
        $vacation = VacationType::find($type_id);
        $final_balance = $vacation->number_days - $balance;
        if ($final_balance > 0) {
            $final_balance = $final_balance;
        } else {
            return $final_balance = 0;
        }
        return $this->successResponse($final_balance);

    }
}
