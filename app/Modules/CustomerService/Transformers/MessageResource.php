<?php

namespace App\Modules\CustomerService\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'name' => $this->name,
            'identity_number' => $this->identity_number,
            'phone' => $this->phone,
            'text' => $this->text,
            'type' => $this->type,
            'date' => $this->created_at_date,
            'time' => $this->created_at_time,
            'created_at' => $this->created_at_date_time,
            'employee' => EmployeeResource::make($this->employee)
        ];
    }
}
