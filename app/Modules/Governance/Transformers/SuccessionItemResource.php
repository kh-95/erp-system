<?php

namespace App\Modules\Governance\Transformers;

use App\Foundation\Classes\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessionItemResource extends JsonResource
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
            'id'   => $this->id,
            'item' => $this->item,
        ];
    }
}
