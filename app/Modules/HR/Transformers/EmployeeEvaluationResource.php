<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEvaluationResource extends JsonResource
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
            'auth_user_management'=> ManagementResource::make($this->whenLoaded('management')),
            'evaluation_date'=> $this->evaluation_date,
            'started_at'=> $this->started_at,
            'ended_at'=> $this->ended_at,
            'ended_at'=> $this->ended_at,
            'employee' => EmployeeResource::make($this->whenLoaded('employee')),
            'employee_evaluations' => EmployeeEvaluationItemResource::collection($this->whenLoaded('employeeeEvaluatiuons')),
            'recommndation' => $this->recommndation,
            'notes' => $this->notes,
        ];
    }
}
