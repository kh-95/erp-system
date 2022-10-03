<?php

namespace App\Modules\CustomerService\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee' => EmployeeResource::make($this->employee),
            'convert_to_employee_id' => EmployeeResource::make($this->convertEmployee),
            'duration' => $this->duration,
            'client_name' => $this->client_name,
            'client_identity_number' => $this->client_identity_number,
            'client_phone' => $this->client_phone,
            'status' => $this->status,
            'media' => $this->media,
            'rate' => $this->rate,
            'waiting_time_in_queue' => $this->waiting_time_in_queue,
            'date' => $this->created_at_date,
            'time' => $this->created_at_time,
            'created_at' => $this->created_at_date,
            'updated_at' => $this->updated_at_date
        ];
    }
}
