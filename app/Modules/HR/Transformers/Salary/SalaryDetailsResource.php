<?php

namespace App\Modules\HR\Transformers\Salary;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\AllowanceResource;


class SalaryDetailsResource extends JsonResource
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
            'employee_name' => $this->employee?->first_name,
            'management_name' => $this->employee?->job?->management?->name,
            'employee_number' => $this->employee?->jobInformation?->employee_number,
            'identification_number' => $this->employee?->identification_number,
            'month' => $this->month,
            'base_salary' => $this->base_salary,
            'gross_salary' => $this->gross_salary,
            'allowances' => AllowanceResource::collection($this->employee->allowances) ?? [],
            'is_signed' => $this->is_signed,
            'current_month_deducts' => $this->current_month_deducts ?? 0,
            'deferred_deducts' => $this->deferred_deducts ?? 0,
            'total_detucts' => $this->current_month_deducts + $this->deferred_deducts,
            'deduction_percentage' => $this->deduction_percentage * 100 . '%',
            'net_salary' => $this->net_salary,
            'created_at' => $this->created_at,
        ];
    }
}
