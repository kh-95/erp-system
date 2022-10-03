<?php

namespace App\Modules\RiskManagement\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transaction_number' => $this->transaction_number,
            'amount' => $this->amount,
            'created_at' => $this->created_at_date,
            'created_at_time' => $this->created_at_date_time,
            'payment_status' => trans('riskmanagement::risk_management.transactions.status_' . $this->payment_status),
            'payment_type' => trans('riskmanagement::risk_management.transactions.type_' . $this->payment_type),
            'transaction_payment_type' => $this->payment_type,
            'transaction_payment_ar' => $this->payment_type_ar,
            'vendor' => VendorResource::make($this->vendor),
            'attachments' => AttachmentResource::collection($this?->attachments),
        ];
    }
}
