<?php

namespace App\Modules\HR\Transformers;

use App\Modules\HR\Transformers\ManagementResource;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'management_id' => $this->management_id,
            'management' => new ManagementResource($this->whenLoaded('management')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'is_manager'=>$this->is_manager,
            'salary_type'=>$this->salary_type,
            'employees_job_count' => $this->employees_job_count,
            'description' => $this->description,
            'deactivated_at' => $this->deactivated_at,
            'created_at'  => $this->created_at,
            'employees_count' => $this->employees_count,
            'is_active'  => (boolean) !$this->deactivated_at,
            'is_empty'  =>  $this->is_empty,
            'actions' => [
                'create' => auth()->user()->can('create-hr_job'),
                'update' => auth()->user()->can('edit-hr_job'),
                'destroy' => auth()->user()->can('delete-hr_job'),
                'show' => auth()->user()->can('list-hr_job'),
                'restore' => auth()->user()->can('archive-hr_job')
            ]
        ];
    }
}
