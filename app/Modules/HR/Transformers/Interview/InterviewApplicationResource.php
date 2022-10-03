<?php

namespace App\Modules\HR\Transformers\Interview;

use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ItemResource;
use App\Modules\HR\Transformers\JobResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewApplicationResource extends JsonResource
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
            'identity_number' => $this->identity_number,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'note' => $this->note,
            'total_score' => $this->total_score,
            'recommended' => (boolean)$this->recommended,
            'is_blocked' => $this->is_blocked,
            'items' => InterviewItemResource::collection($this->items()->withTranslation()->get()),
        ];
    }
}
