<?php

namespace App\Modules\TempApplication\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'indentity' => $this->indentity,
            'mobile' => $this->mobile,
            'contract_number' => $this->contract_number
        ];
    }
}
