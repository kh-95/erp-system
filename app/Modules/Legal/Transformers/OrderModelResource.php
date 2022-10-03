<?php

namespace App\Modules\Legal\Transformers;

use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ManagementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderModelResource extends JsonResource
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
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'management' => ManagementResource::make($this->whenLoaded('management')),
            'employee' => EmployeeResource::make($this->whenLoaded('employee')),
            'attachments' => OrderAttachmentResource::collection($this->whenLoaded('attachments')),
            'request_subject' => $this->request_subject,
            'request_text' => $this->request_text,
            'request_date' => $this->request_date,
            'islamic_date' => $this->islamic_date,
            'consults' => ConsultResource::collection($this->whenLoaded('consults')),

        ];
    }
}
