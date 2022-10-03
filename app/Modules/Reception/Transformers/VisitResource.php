<?php

namespace App\Modules\Reception\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\Reception\Transformers\VisitorResource;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Transformers\ActivityResource;

class VisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'date' => $this->date,
           'time' => $this->time,
           'time_type' => $this->time_type,
           'management_id' => $this->management_id,
           'type' => $this->type,
           'note' => $this->note,
           'status' => $this->status,
           'visitors' => VisitorResource::collection($this->whenLoaded('visitors')),
           'employees' => EmployeeResource::collection($this->whenLoaded('employees')),
           'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
