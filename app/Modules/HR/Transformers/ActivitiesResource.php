<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiesResource extends JsonResource
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
            'name' => $this->name,
            'main_program_id' => $this->main_program_id,
            'sup_program_id' => $this->sup_program_id,
            'management_id' => new ManagementResource($this->whenLoaded('management')),
            'employee_id' => new ManagementResource($this->whenLoaded('employee')),
            'date_from' => $this->date_from,
            'date_to' => $this->date_from,
        ];
    }
}
