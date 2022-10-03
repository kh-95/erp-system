<?php

namespace App\Modules\Governance\Transformers;

use App\Modules\HR\Transformers\JobResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessionResource extends JsonResource
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
            'is_active' => (bool)$this->is_active,
            'created_at' => $this->created_at_date ?? "",
            'plan_from' => $this->plan_from ?? "",
            'plan_to' => $this->plan_to ?? "",
            'percentage' => $this->percentage,
            'management' => ManagementResource::make($this->management),
            'job' => JobResource::make($this->job),
            'attachments' => AttachmentResource::collection($this->attachments),
            'items' => SuccessionItemResource::collection($this->items),

        ];
    }
}
