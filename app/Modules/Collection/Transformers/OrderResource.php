<?php

namespace App\Modules\Collection\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;
use App\Modules\TempApplication\Transformers\CustomerResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'order_types' => $this->order_types,
            'order_subject' => $this->order_subject,
            'order_text' => $this->order_text,
            'order_date' => $this->order_date,
            'customer_type' => $this->customer_type,
            'mobile' => $this->mobile,
            'identity' => $this->identity,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'customer' => CustomerResource::collection($this->whenLoaded('customer')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
