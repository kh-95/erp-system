<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RecieptCustomerResource extends JsonResource
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
            'customer_identity' => $this->customer_identity,
            'phone' => $this->phone,
            'premium' => $this->premium,
            'premium_number' => $this->premium_number,
            'premium_date' => $this->premium_date,
            'premium_value' => $this->premium_value,
        ];
    }
}
