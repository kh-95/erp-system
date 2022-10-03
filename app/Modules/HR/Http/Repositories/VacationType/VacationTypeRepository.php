<?php

namespace App\Modules\HR\Http\Repositories\VacationType;

use App\Modules\HR\Entities\VacationType;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\VacationTypeResource;
use App\Repositories\CommonRepositoryInterface;
use App\Modules\HR\Http\Requests\VacationTypeRequest;


class VacationTypeRepository extends CommonRepository implements VacationTypeRepositoryInterface
{
    use ApiResponseTrait;
    protected function filterColumns() :array
    {
        return [
            'name',
            'deactivated_at',
            'id'
        ];
    }

    public function model()
    {
        return VacationType::class;
    }


    public function destroy($id)
    {
        $type = $this->find($id);
       // if($this->doesntHaveRelations($id,['employees']))
        //{
            $this->delete($id);
            return $this->successResponse(['message'=>__('hr::messages.vacationtype.deleted_successfuly')]);
        //}
        //return $this->errorResponse(['message'=>__('hr::messages.nationality.record_found')]);
    }

    public function changeStatus($id)
    {
        $type = $this->find($id);
       /* if($this->scopeActive($nationality->employees())->count())
        {
            return $this->errorResponse(['message'=>__('hr::messages.nationality.record_found_disable')]);
        }*/
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('hr::messages.vacationtype.toggle_successfuly')]);
    }

    public function restore($id)
    {
        $record=$this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message'=>__('hr::messages.nationality.restored_successfuly')]);

    }

    public function store(VacationTypeRequest $request)
    {
        try {
        $data = $request->except(['number_days']);
        $data['number_days'] = $request->number_days;
        $type = $this->create($data);
        return $this->successResponse(new VacationTypeResource($type));
        } catch (\Exception $exception) {
        return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }


    public function updatevacationtype($request,$id)
    {
        try {
        $type = $this->find($id);
        $data = $request->except(['number_days']);
        $data['number_days'] = $request->number_days;
        $type = $this->update($data, $id);
        return $this->successResponse(new VacationTypeResource($type));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }
}
