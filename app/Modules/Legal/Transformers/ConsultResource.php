<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultResource extends JsonResource
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
            'text' => $this->text,
            'status' => $this->status,
            'opinion' => LegalOpinionResource::make($this->whenLoaded('opinion')),
        ];
    }
}
