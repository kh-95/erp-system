<?php

namespace App\Modules\CustomerService\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employee_number' => $this->jobInformation?->employee_number,
            'name' => $this->fullname,
            'calls_count' => $this?->calls?->count() ?? 0,
            'messages_count' => $this?->messages?->count() ?? 0,
            'sms_messages_count' => $this?->messages?->where('type', 'sms')?->count() ?? 0,
            'whatsapp_messages_count' => $this?->messages?->where('type', 'whatsapp')?->count() ?? 0,
            'calls_duration' => $this->calls?->sum('duration') ?? 0,
            'calls_average' => $this->calls->avg('duration') ?? 0,
            'call_status' => $this->call_status,
        ];
    }
}
