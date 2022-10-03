<?php

namespace App\Modules\Legal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyCaseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'session_date1' => $this->session_date1,
            'session_date2' => $this->session_date2,
            'notes' => $this->notes,
        ];
    }
}
