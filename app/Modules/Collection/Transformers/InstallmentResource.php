<?php

namespace App\Modules\Collection\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
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
                'date_from' => $this->date_from,
                'date_to' => $this->date_to,
                'status' => $this->status,
                'amount_from' => $this->amount_from,
                'amount_to' => $this->amount_to,
                'date_entitlement' => $this->date_entitlement,
                'penalty_value_delay' => $this->penalty_value_delay,
                'customer_name' => $this->customer?->name,
                'customer_indentity' => $this->customer?->indentity,
                'customer_phone' => $this->customer?->mobile,
                'customer_service_id' => $this->customer?->name,
                'created_at' =>$this->created_at

        ];
    }
}
