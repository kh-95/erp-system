<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CommitteeResource extends JsonResource
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
            'name' => $this->name,
            'creation_date'=>$this->creation_date,
            'is_active' => (bool)$this->is_active,
            'attachments' => AttachmentResource::collection($this->attachments),
            'employees' => EmployeeResource::collection($this->employees),
        ];
    }
}
