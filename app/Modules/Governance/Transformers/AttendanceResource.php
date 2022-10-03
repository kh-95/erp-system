<?php

namespace App\Modules\Governance\Transformers;

use App\Modules\HR\Transformers\ManagementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'management' => ManagementResource::make($this->whenLoaded('management'))
        ];
    }
}
