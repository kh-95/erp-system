<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyCasePaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payment_date_from' => $this->payment_date_from,
            'payment_date_to' => $this->payment_date_to,
            'paid_amount' => $this->paid_amount,
            'remaining_amount' => $this->remaining_amount,
        ];
    }
}
