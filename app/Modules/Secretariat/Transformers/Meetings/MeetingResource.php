<?php

namespace App\Modules\Secretariat\Transformers\Meetings;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'time_format' => $this->time_format,
            'meeting_room' => $this->room->name,
            'type' => $this->type,
            'meeting_duration' => $this->meeting_duration,
            'note' => $this->note,
            'employees' => EmployeeMeetingResource::collection($this->whenLoaded('employees')),
            'decisions' => MeetingDecisionResource::collection($this->whenLoaded('decisions')),
            'discussionPoints' => MeetingDiscussionPointResource::collection($this->whenLoaded('discussionPoints')),
        ];
    }
}
