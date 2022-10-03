<?php

namespace App\Modules\HR\Transformers;

use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagementResource extends JsonResource
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
            'parent' => new ManagementResource($this->whenLoaded('parent')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'deactivated_at'  => $this->deactivated_at,
            'is_active'  => (bool) !$this->deactivated_at,
            'is_vacant' => $this->is_vacant
        ];
    }
}
