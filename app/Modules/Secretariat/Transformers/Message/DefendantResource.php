<?php

namespace App\Modules\Secretariat\Transformers\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class DefendantResource extends JsonResource
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
            'customer_type' => $this->customer_type,
            'branch' => $this->branch,
            'register_number' => $this->register_number,
        ];
    }
}
