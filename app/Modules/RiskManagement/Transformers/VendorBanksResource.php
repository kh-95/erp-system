<?php

namespace App\Modules\RiskManagement\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;


class VendorBanksResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'iban' => $this->pivot->iban,
            'status' => $this->pivot->status,
        ];
    }
}
