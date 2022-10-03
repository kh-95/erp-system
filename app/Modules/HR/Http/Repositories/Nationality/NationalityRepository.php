<?php

namespace App\Modules\HR\Http\Repositories\Nationality;

use App\Modules\HR\Entities\Nationality;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\NationlityResource;
use App\Repositories\CommonRepositoryInterface;

class NationalityRepository extends CommonRepository implements NationalityRepositoryInterface
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
        return Nationality::class;
    }


    public function destroy($id)
    {
        $nationality = $this->find($id);
        if($this->doesntHaveRelations($id,['employees']))
        {
            $this->delete($id);
            return $this->successResponse(['message'=>__('hr::messages.nationality.deleted_successfuly')]);
        }
        return $this->errorResponse(['message'=>__('hr::messages.nationality.record_found')]);
    }

    public function changeStatus($id)
    {
        $nationality = $this->find($id);
        if($this->scopeActive($nationality->employees())->count())
        {
            return $this->errorResponse(['message'=>__('hr::messages.nationality.record_found_disable')]);
        }
        $this->toggleStatus($id);
        return $this->successResponse(['message'=>__('hr::messages.nationality.toggle_successfuly')]);
    }

    public function restore($id)
    {
        $record=$this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message'=>__('hr::messages.nationality.restored_successfuly')]);

    }

}
