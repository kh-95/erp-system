<?php

namespace App\Modules\Governance\Transformers;

use App\Modules\HR\Entities\HoldHarmless\HoldHarmless;
use App\Modules\HR\Transformers\Employee\JobInformationResource;
use App\Modules\HR\Transformers\HoldHarmless\HarmlessResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray($request)
    {
        // dd($this->holdharmlesses);
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'identity_number' => $this->identification_number,
            'hiring_date' => $this->jobInformation?->receiving_work_date,
            'phone' => $this->phone,
            'qualification_level' => $this->qualification,
            'qualification_name' => $this->qualification,
            'status' => (bool) $this->deactivated_at,
            'nationality' => $this->nationality?->name,
            'identity_date' => $this->identity_date,
            'identity_source' => $this->identity_source,
            'is_director' => (bool) $this->is_directorship_president,
            'holdharmless_date'=>$this->holdharmlesses->first()?->created_at ?? "",
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'jobInformation' => new JobInformationResource($this->whenLoaded('jobInformation')),
            'another_certifications' => [],
            'courses' =>$this->trainingCourses->first()?->course_name ?? ""
        ];
    }
}
