<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'employee_number' => $this->employee_number,
            'receiving_work_date' => $this->receiving_work_date,
            'contract_period' => $this->contract_period,
            'salary_percentage' => $this->salary_percentage,
            'salary' => $this->salary,
            'other_allowances' => $this->other_allowances,
        ];
    }
}
