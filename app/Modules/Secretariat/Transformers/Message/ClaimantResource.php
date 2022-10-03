<?php

namespace App\Modules\Secretariat\Transformers\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class ClaimantResource extends JsonResource
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
            'contract_number' => $this->contract_number,
            'identity_number' => $this->identity_number,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'register_number' => $this->register_number,
            'tax_number' => $this->tax_number,
        ];
    }
}
