<?php

namespace App\Modules\Reception\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Reception\Transformers\VisitResource;

class VisitorResource extends JsonResource
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
            'identity_number' => $this->identity_number,
            'visit_id' => $this->visit_id,
        ];
    }
}
