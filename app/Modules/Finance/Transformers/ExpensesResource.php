<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class ExpensesResource extends JsonResource
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
            'date' => $this->receipt_date,
            'certificate_number' => $this->certificate_number,
            'money' => $this->money,
            'from_cash_register' => $this->from_cash_register,
            'to_cash_register' => $this->to_cash_register,
            'management_id' => $this->management_id,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'expensesCustomer' => RecieptCustomerResource::make($this->whenLoaded('expensesCustomer')),
            'expensesCustomerWithService' => RecieptCustomerServiceResource::make($this->whenLoaded('expensesCustomerService')),
            'expensesCustomerAccount' => RecieptCustomerAccountResource::make($this->whenLoaded('expensesCustomerAccount')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
