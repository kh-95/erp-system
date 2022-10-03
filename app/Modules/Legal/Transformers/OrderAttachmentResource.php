<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'attachment' => $this->media
        ];
    }
}
