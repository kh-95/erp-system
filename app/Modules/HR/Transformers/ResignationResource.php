<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class ResignationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employeeOfresignation->identification_number,
            'employee_name' => $this->employeeOfresignation->full_name,
            'management'=>$this->employeeOfresignation->employeejob->first()?->management->name,
            'job'=>$this->employeeOfresignation->employeejob->first()?->name,
            'resignation_date'=>$this->resignation_date,
            'notes' => $this->notes,
            'deactivated_at' => ($this->deactivated_at)?false:true,
            'created_at' => $this->created_at,
            'attachment'=>$this->attachments,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
