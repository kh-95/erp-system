<?php

namespace App\Modules\Legal\Transformers\Agenecy;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'media' => $this->media,
        ];
    }
}
