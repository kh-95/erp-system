<?php

namespace App\Modules\CustomerService\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDetailsResource extends JsonResource
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
            'name' => $this->fullname,
            'employee_number' => $this->jobInformation?->employee_number,
            'rate' => $this->calls()->avg('rate') ?? 0,
            'call_status' => $this->call_status,
            'calls' => CallResource::collection($this->calls),
            'sms_messages' => MessageResource::collection($this->messages?->where('type', 'sms')),
            'whatsapp_messages' => MessageResource::collection($this->messages?->where('type', 'whatsapp')),
        ];
    }
}
