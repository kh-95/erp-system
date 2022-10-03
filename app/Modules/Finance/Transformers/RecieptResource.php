<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class RecieptResource extends JsonResource
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
            'pay_status' => $this->pay_status,
            'check_number' => $this->check_number,
            'money_order_number' => $this->money_order_number,
            'receipt_date' => $this->receipt_date,
            'certificate_number' => $this->certificate_number,
            'certificate_date' => $this->certificate_date,
            'money' => $this->money,
            'cash_register' => $this->cash_register,
            'management_id' => $this->management_id,
            'Receipt_request_number' => $this->Receipt_request_number,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'receiptCustomer' => RecieptCustomerResource::make($this->whenLoaded('receiptCustomer')),
            'receiptCustomerWithService' => RecieptCustomerServiceResource::make($this->whenLoaded('receiptCustomerService')),
            'receiptCustomerAccount' => RecieptCustomerAccountResource::make($this->whenLoaded('receiptCustomerAccount')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
