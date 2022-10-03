<?php

namespace App\Modules\Secretariat\Transformers\Meetings;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeMeetingResource extends JsonResource
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
            'employee_id' => $this->id,
            'name' => $this->first_name,
            'employee_meeting_id' => $this->pivot->id,
            'status' => $this->pivot->status,
            'rejected_reason' => $this->pivot->rejected_reason,

        ];
    }
}
