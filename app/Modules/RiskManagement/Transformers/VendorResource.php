<?php

namespace App\Modules\RiskManagement\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'name' => $this->name,
            'identity_number' => $this->identity_number,
            'created_at' => $this->created_at_date,
            'class' => $this?->class?->name,
            'banks' => VendorBanksResource::collection($this->banks),
            'commercial_record' => $this->commercial_record,
            'tax_number' => $this->tax_number,
            'rasid_jack' => $this->rasid_jack,
            'rasid_maak' => $this->rasid_maak,
            'rasid_pay' => $this->rasid_pay,
            'total_pays' => $this->total_pays,
            'type' => trans('riskmanagement::risk_management.vendors.type_' . $this->type),
            'vendor_type' => $this->type,
            'subscription' => trans('riskmanagement::risk_management.vendors.subscription_' . $this->subscription),
            'vendor_subscription' => $this->subscription,
            'daily_expected_sales_amount' => $this->daily_expected_sales_amount ?? 0,
            'daily_expected_activity_amount' => $this->daily_expected_activity_amount ?? 0,
            'maak_service_provider' => $this->maak_service_provider ?? false,
            'pay_service_provider' => $this->pay_service_provider ?? false,
            'is_active' => (boolean)$this->is_active,
            'attachments' => AttachmentResource::collection($this?->attachments) ?? [],
        ];
    }
}
