<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->employees);
        if(auth()->user()->employee_number == '123456'){
            $employees = EmployeeResource::collection($this->whenLoaded('employees'));
        }else{

            $employee = $this->employees()->where('employee_id',auth()->user()->employee?->id)->first();
            $employees = EmployeeResource::make($employee);
        }
        return [
            'id' => $this->id,
            'subject'=> $this->subject,
            'is_online' => (bool)$this->is_online,
            'meeting_type' => $this->meeting_types,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'meeting_replication' => $this->meeting_replication,
            'notes' => $this->notes,
            'meeting_place' => MeetingPlaceResource::make($this->whenLoaded('meetingPlace')),
            'points' => PointResource::collection($this->whenLoaded('points')),
            'employees' => $employees,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
