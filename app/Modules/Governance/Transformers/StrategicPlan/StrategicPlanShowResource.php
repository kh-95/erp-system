<?php

namespace App\Modules\Governance\Transformers\StrategicPlan;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Governance\Transformers\AttachmentResource;
use App\Modules\Governance\Transformers\StrategicPlan\StrategicPlanAttributeResource;

class StrategicPlanShowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'from' => $this->from,
            'to' => $this->to,
            'is_active' => (bool) $this->is_active,
            'achieved' => $this->achieved,
            'vision' => $this->title,
            'tasks' => StrategicPlanAttributeResource::collection($this->planAttributeType('tasks')),
            'terms' => StrategicPlanAttributeResource::collection($this->planAttributeType('terms')),
            'goals' => StrategicPlanAttributeResource::collection($this->planAttributeType('goals')),
            'requirements' => StrategicPlanAttributeResource::collection($this->planAttributeType('requirements')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),

        ];
    }
}
