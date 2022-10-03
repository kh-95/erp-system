<?php

namespace App\Modules\HR\Http\Repositories\Job;

use App\Modules\HR\Entities\Job;
use App\Repositories\CommonRepository;
use App\Modules\HR\Http\Repositories\Job\JobRepositoryInterface;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\DeactivatedTrait;
use App\Modules\HR\Transformers\JobResource;

class JobRepository extends CommonRepository implements JobRepositoryInterface
{
    use ApiResponseTrait, DeactivatedTrait;

    protected function filterColumns(): array
    {
        return [
            $this->translated('name'),
            'management_id',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            $this->deactivatedAt('deactivated_at'),
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            $this->translated('name'),
            'management_id',
            'contract_type',
        ];
    }

    public function checkJobName(string $name, int $management_id)
    {
        if ($this->model->whereTranslation('name', $name)->where('management_id', $management_id)->count()) {
            return $this->errorResponse(data: ['name' => [__('hr::messages.job.check_name_unique_faild')]]);
        }
        return $this->successResponse();
    }

    public function deactivated_at($id)
    {
        if ($this->doesntHaveRelations($id, ['employees'])) {
            $this->toggleStatus($id);
            return $this->successResponse(['message' => __('hr::messages.job.toggle_successfuly')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.job.record_found')]);
    }
    public function update(array $request, $id)
    {
        $job = $this->model->find($id);
        $status = (bool) $request['deactivated_at'];
        $job->update($request);
        return $this->successResponse(new jobResource($job), true, __('hr::messages.job.edit_successfuly'));
    }
    
    public function forExternalServices(array $attributes)
    {
        return $this->scopeActive($this->model->where('employees_job_count', '>', 'employees.count')->select($attributes))->get();
    }

    public function destroy($id)
    {
        if ($this->doesntHaveRelations($id, ['employees'])) {
            $this->delete($id);
            return $this->successResponse(['message' => __('hr::messages.job.deleted_successfuly')]);
        }
        return $this->errorResponse(['message' => __('hr::messages.job.record_found')]);
    }

    public function restore($id)
    {
        $record = $this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message' => __('hr::messages.job.restored_successfuly')]);
    }

    public function model()
    {
        return Job::class;
    }
}
