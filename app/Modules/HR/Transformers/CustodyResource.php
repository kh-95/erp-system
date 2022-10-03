<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustodyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'count' => $this->count,
            'description' => $this->description,
            'received_date' => $this->received_date,
            'delivery_date' => $this->delivery_date,
        ];
    }
}
