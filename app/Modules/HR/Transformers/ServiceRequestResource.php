<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this);
        return [
            'id' => $this->id,
            'management' => ManagementResource::make($this->whenLoaded('management')),
            'employee' => EmployeeResource::make($this->whenLoaded('employee')),
            'service_type' => $this->service_type,
            'directed_to' => $this->directed_to,
            'notes' => $this->notes,
            'status' => $this->status,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'response' => ServiceResponseResource::make($this->whenLoaded('serviceresponse')),
            'actions' => [
                'create' => auth()->user()->can('create-hr_services'),
                'update' => auth()->user()->can('update-hr_services'),
                'show' => auth()->user()->can('show-hr_services'),
            ]
        ];
    }
}
