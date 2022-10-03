<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'event' => $this->event,
            'action_by' => $this->causer?->employee?->full_name,
            'manaegment' => $this->causer?->employee?->job?->management?->name,
            'properties' => $this->whenNotNull($this->properties['attributes'] ?? null),
            'old' => $this->whenNotNull($this->properties['old'] ?? null),
            'created_at' => $this->created_at?->format('d-m-Y H:i')
        ];
    }
}
