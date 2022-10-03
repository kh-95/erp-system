<?php

namespace App\Modules\Legal\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalOpinionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'text'=>$this->text,
        ];
    }
}
