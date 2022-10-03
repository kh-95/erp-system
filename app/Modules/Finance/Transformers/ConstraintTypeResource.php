<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class ConstraintTypeResource extends JsonResource
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
            'name'=>$this->name,
            'notes'=>$this->notes,
            'deactivated_at' => ($this->deactivated_at)?false:true,
            'created_at' => $this->created_at,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
