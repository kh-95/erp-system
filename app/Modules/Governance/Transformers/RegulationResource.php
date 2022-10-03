<?php

namespace App\Modules\Governance\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegulationResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'is_active' => (boolean)$this->is_active,
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'attachments' => RegulationAttachmentResource::collection($this->whenLoaded('regulationAttachments')),
        ];
    }
}
