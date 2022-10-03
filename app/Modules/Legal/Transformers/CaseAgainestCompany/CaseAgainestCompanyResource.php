<?php

namespace App\Modules\Legal\Transformers\CaseAgainestCompany;

use App\Modules\HR\Transformers\AttachmentResource;
use App\Modules\HR\Transformers\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseAgainestCompanyResource extends JsonResource
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
            'court_number' => $this->court_number,
            'court_type' => $this->court_type,
            'area' => $this->area,
            'case_filing_date' => $this->case_filing_date,
            'case_filing_date_hijri' => $this->case_filing_date_hijri,
            'status' => $this->status,
            'latest_date_session_for_court' => $this->latest_date_session_for_court,
            'case_fee' => number_format($this->case_fee,2),
            'employee'  => EmployeeResource::make($this->whenLoaded('employee')),
            'claimant' => ClaimantResource::make($this->whenLoaded('claimant')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
