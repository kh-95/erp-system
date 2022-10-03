<?php

namespace App\Modules\Reception\Transformers;

use App\Modules\HR\Transformers\ManagementResource;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionReportResource extends JsonResource
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
            'title' => $this->title,
            'management_id' => $this->management_id,
            'management' => new ManagementResource($this->whenLoaded('management')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'description' => $this->description,
            'status' => $this->status,
            'date' => $this->date,
            'time'=>$this->time,
            'time_type'=>$this->time_type,
            'check_update'=>$this->check_update
        ];
    }
}
