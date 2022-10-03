<?php

namespace App\Modules\Legal\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyCaseResource extends JsonResource
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
            'case_number' => $this->case_number,
            'order_number' => $this->order_number,
            'judicial_department' => $this?->judicial_department?->name,
            'case_date1' => $this->case_date1,
            'case_date2' => $this->case_date2,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'status' => $this->status,
            'reconciliation_status' => $this->reconciliation_status,
            'execution_status' => $this->execution_status,
            'execution_number' => $this->execution_number,
            'execution_area_number' => $this->execution_area_number,
            'decision_34' => (bool)$this->decision_34,
            'decision_46' => (bool)$this->decision_46,
            'decision_83' => (bool)$this->decision_83,
            'payment' => $this->payment,
            'time_out_duration' => $this->time_out_duration ?? "",
            'time_out_date1' => $this->time_out_date1 ?? "",
            'time_out_date2' => $this->time_out_date2 ?? "",
            'vendor_name' => $this->vendor_name,
            'vendor_identity_number' => $this->vendor_identity_number,
            'vendor_phone' => $this->vendor_phone,
            'contract_number' => $this->contract_number,
            'late_installments' => $this->late_installments,
            'installments_amount' => $this->installments_amount,
            'employee' => EmployeeResource::make($this?->employee),
            'sessions' => CompanyCaseSessionResource::collection($this->sessions),
            'payments' => CompanyCasePaymentResource::collection($this->payments),
            'attachments' => AttachmentResource::collection($this->attachments),
        ];
    }
}
