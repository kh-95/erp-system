<?php

namespace App\Modules\RiskManagement\Transformers\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationTermResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'field' => $this->field,
            'operator' => $this->operator,
            'value' => $this->value,
            'join_operator' => $this->join_operator,
            'order' => $this->order
        ];
    }
}
