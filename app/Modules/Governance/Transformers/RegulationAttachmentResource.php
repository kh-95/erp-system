<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RegulationAttachmentResource extends JsonResource
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
            'media' => $this->media,
            'type' => $this->type
        ];
    }
}
