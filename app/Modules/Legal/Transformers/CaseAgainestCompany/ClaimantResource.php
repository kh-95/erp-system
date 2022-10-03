<?php

namespace App\Modules\Legal\Transformers\CaseAgainestCompany;

use Illuminate\Http\Resources\Json\JsonResource;

class ClaimantResource extends JsonResource
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
            'claimant_name' => $this->claimant_name,
            'identity_number' => $this->identity_number,
        ];
    }
}
