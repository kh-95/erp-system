<?php

namespace App\Modules\Collection\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
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
            'operation_number' => $this->operation_number,
            'amount' => $this->amount,
            'customer_name' => $this->customer->name,
            'customer_mobile' => $this->customer->mobile,
            'customer_contract_number' => $this->customer->contract_number,
            'customer_indentity' => $this->customer->indentity,
            'customer_service_name' => $this->customer->name,
            'customer_service_contract_number' => $this->customer->contract_number,
            'customer_service_tax_number' => $this->customer->contract_number,
            'customer_service_record_number' => $this->customer->contract_number,
            'installment_count'=> '5',
            'installment_amount'=> $this->amount,
            'total_installments'=>'5',
            'remaining_installments_count'=> '5',
            'status' => $this->status,
            'date' => $this->date,

        ];
    }
}
