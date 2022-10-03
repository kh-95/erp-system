<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidacyApplicationResource extends JsonResource
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
            'candidate_name' => $this->candidate_name,
            'identity_number'=>$this->identity_number,
            'phone' => $this->phone,
            'qualification_level' => $this->qualification_level,
            'nationality' =>$this->nationality?->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'is_active' => (bool) $this->is_active,
            'attachments' => CandidacyAttachmentResource::collection($this->whenLoaded('attachments')),



        ];
    }
}
