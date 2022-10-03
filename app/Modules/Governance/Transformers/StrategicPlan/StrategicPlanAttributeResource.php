<?php

namespace App\Modules\Governance\Transformers\StrategicPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class StrategicPlanAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            $this->mergeWhen($this->type == 'requirements', [
                'achievement_method' => $this->achievement_method,
            ]),
        ];
    }
}
