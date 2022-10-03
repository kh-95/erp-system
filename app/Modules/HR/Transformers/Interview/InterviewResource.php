<?php

namespace App\Modules\HR\Transformers\Interview;

use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\JobResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $count_candidates = InterviewApplication::where(['interview_id' => $this->id, 'recommended' => 1])->count();
        return [
            'id' => $this->id,
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'job' => JobResource::make($this->whenLoaded('job')),
            'applications' => InterviewApplicationResource::collection($this->whenLoaded('applications')),
            'count_candidates' => $count_candidates,
            'applications_count' => $this->applications_count,
            'members' => EmployeeResource::collection($this->whenLoaded('committeeMembers')),
            'created_at' => $this->created_at->format('d-m-Y')

        ];
    }
}
