<?php

namespace App\Modules\HR\Http\Repositories\Management;

use App\Modules\HR\Entities\Management;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Transformers\ManagementResource;
use Illuminate\Database\Eloquent\Collection;

class ManagementRepository extends CommonRepository implements ManagementRepositoryInterface
{
    use ApiResponseTrait;

    protected function filterColumns(): array
    {
        return [
            $this->translated('name'),
            'parent_id',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            $this->deactivatedAt('deactivated_at'),
            'status'
        ];
    }
    public function forExternalServices(array $attributes)
    {
        return $this->scopeActive($this->model->select($attributes))->get();
    }

    public function checkManagementName($name)
    {
        if ($this->model->whereTranslation('name', $name)->count()) {
            return $this->errorResponse(data: ['name' => [__('hr::messages.management.check_name_unique_faild')]]);
        }
        return $this->successResponse();
    }

    public function sortColumns()
    {
        return [
            'id',
            'name',
            'parent_id',
            'created_at',
            'status'
        ];
    }

    public function update(array $request, $id)
    {
        $management = $this->model->find($id);
        $status = (bool) $request['deactivated_at'];
        $management->update($request);
        return $this->successResponse(new ManagementResource($management), true, __('hr::messages.management.edit_successfuly'));
    }

    public function deactivated_at($id)
    {
        if ($this->doesntHaveRelations($id, ['childs', 'jobs'])) {
            $this->toggleStatus($id);
            return $this->successResponse(['message' => __('hr::messages.management.toggle_successfuly')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.management.record_found')]);
    }

    public function destroy($id)
    {
        if ($this->doesntHaveRelations($id, ['childs', 'jobs'])) {
            $this->delete($id);
            return $this->successResponse(['message' => __('hr::messages.management.deleted_successfuly')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.management.record_found')]);
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message' => __('hr::messages.management.restored_successfuly')]);
    }

    public function listManagement(): Collection
    {
        return $this->model()::when(request()->has('is_active'), fn ($q) => $q->active())
            ->ListsTranslations('name')
            ->addSelect('hr_management.id')
            ->get();
    }

    public function model()
    {
        return Management::class;
    }
}
