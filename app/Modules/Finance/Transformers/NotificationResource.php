<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'way' => $this->way,
            'notification_number' => $this->notification_number,
            'date' => $this->date,
            'management_id' => $this->management_id,
            'notification_name' => $this->notification_name,
            'price' => $this->price,
            'complaint_number' => $this->complaint_number,
            'customer_id' => $this->customer_id,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
