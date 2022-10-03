<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResponseResource extends JsonResource
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
            'note' => $this->note,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
