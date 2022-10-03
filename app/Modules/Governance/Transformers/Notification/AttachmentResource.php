<?php

namespace App\Modules\Governance\Transformers\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'media' => $this->media,
            'type' => $this->type
        ];
    }
}
