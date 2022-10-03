<?php

namespace App\Modules\Governance\Transformers\Notification;

use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ManagementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'  =>$this->id,
            'title' => $this->title,
            'body'  => $this->body,
            'employee' => EmployeeResource::make($this->employee),
            'management' => ManagementResource::make($this->employee),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'status' =>$this->status,
            'created_at' => $this->created_at_date_time,
            'updated_at' => $this->updated_at_date_time,
            'response' =>$this?->response
        ];
    }
}
