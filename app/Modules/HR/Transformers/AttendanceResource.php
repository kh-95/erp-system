<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee' => $this->employee?->full_name,
            'management' => $this->employee?->job?->management?->name,
            'employee_number' => $this->employee?->identification_number,
            'date' => $this->created_at_date_time,
            'attended_at' => $this->attended_at,
            'leaved_at' => $this->leaved_at,
            'method' => $this->method,
            'branch' => $this->branch,
            'has_vacation' => (bool)$this->has_vacation,
            'has_permission' => (bool)$this->has_permission,
            'punishment' => $this->punishment,
            'punishment_status' => $this->punishment_status,
            'notes' => $this->notes,
        ];
    }
}
