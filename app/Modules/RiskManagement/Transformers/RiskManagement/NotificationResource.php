<?php

namespace App\Modules\RiskManagement\Transformers\RiskManagement;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
