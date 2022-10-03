<?php

namespace App\Modules\HR\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class JobInformationResource extends JsonResource
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
            'job_id' => $this->job_id,
            'receiving_work_date' => $this->receiving_work_date,
            'contract_period' => $this->contract_period,
            'contract_type' => $this->contract_type,
            'salary' => $this->salary,
            'salary_percentage' => $this->salary_percentage,
            'employee_number' => $this->employee_number,
            'employee_id' => $this->employee_id
        ];
    }
}
