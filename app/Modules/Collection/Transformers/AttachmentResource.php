<?php

namespace App\Modules\Collection\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file' => $this->file,
        ];
    }
}
