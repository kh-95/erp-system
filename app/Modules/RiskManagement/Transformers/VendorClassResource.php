<?php

namespace App\Modules\RiskManagement\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorClassResource extends JsonResource
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
        'name' => $this->name,
        'is_active' => (bool) $this->is_active,
        'created_at' =>$this->created_at

        ];
    }
}
