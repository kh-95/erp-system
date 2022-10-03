<?php

namespace App\Modules\HR\Transformers\TrainingCourse;

use App\Foundation\Classes\Helper;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingCourseResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $attachments = explode("|", $this->attachments);
        $attachmentsArray = [];
        if ($attachments[0] !== "") {
            foreach ($attachments as $attachment) {
                array_push($attachmentsArray, storage_path() .  Helper::BASE_PATH . '/' . 'training_course/' . $attachment);
            }
        }

        return  [
            'id' => $this->id,
            'management_id' => $this->management_id,
            'employee_id' => $this->employee_id,
            'notes' => $this->notes,
            'attachements' => $attachmentsArray,
            'rejection_cause' => $this->rejection_cause,
            'course_name' => $this->course_name,
            'number' => $this->number,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'actual_from_date' => $this->actual_from_date,
            'actual_to_date' => $this->actual_to_date,
            'organization_type' => $this->organization_type,
            'organization_name' => $this->organization_name,
            'expected_fees' => $this->expected_fees,
            'status' => $this->status,
            'actual_start_status' => $this->actual_start_status,
            'activities' => ActivityResource::collection($this->whenLoaded('activities'))
        ];
    }
}
