<?php

namespace App\Modules\HR\Transformers\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractClauseResource extends JsonResource
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
            'item_text' => $this->item_text,
            'nationality' => $this->nationality,
        ];
    }
}
