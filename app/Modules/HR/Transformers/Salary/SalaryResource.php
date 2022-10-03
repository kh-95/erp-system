<?php

namespace App\Modules\HR\Transformers\Salary;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\AllowanceResource;
class SalaryResource extends JsonResource
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
            'net_salary' => $this->net_salary,
            'is_paid' => $this->is_paid,
            'is_signed' => $this->is_signed,
            'allowances' => $this->employee?->allowances,
            'total_deductions' => $this->employee?->totalMonthDeducts(),
            'created_at' => $this->created_at,
            'actions' => [
                'update' => auth()->user()->can('edit-salary'),
                'show' => auth()->user()->can('show-salary'),
                'change-salary-status' => auth()->user()->can('change-salary-status'),
                'get-salary-status' => auth()->user()->can('get-salary-status'),
            ],
        ];
    }
}
