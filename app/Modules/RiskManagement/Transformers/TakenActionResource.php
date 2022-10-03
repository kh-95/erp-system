<?php

namespace App\Modules\RiskManagement\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TakenActionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'taken_action' => $this->taken_action,
            'reasons' => $this->reasons,
            'created_at' => $this->created_at_date,
            'attachments' => AttachmentResource::collection($this->attachments)
        ];
    }
}
