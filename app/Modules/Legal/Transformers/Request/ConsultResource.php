<?php

namespace App\Modules\Legal\Transformers\Request;

use App\Modules\Legal\Transformers\LegalOpinionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultResource extends JsonResource
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
            'consult_number' => $this->id,
            'management' => $this->job?->management?->name,
            // 'legal_opinion' =>LegalOpinionResource::make($this->whenLoaded('consult_id')),
            'employee' => $this->employee?->full_name,
            'consult_subject' => $this->request_subject,
            'consult_text' => $this->request_text,
            'status' => $this->status,
            'consult_date' => $this->created_at

        ];
    }
}
