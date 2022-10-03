<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RecieptCustomerServiceResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'register_id' => $this->register_id,
            'tax_id' => $this->tax_id,
            'iban' => $this->iban,
        ];
    }
}
