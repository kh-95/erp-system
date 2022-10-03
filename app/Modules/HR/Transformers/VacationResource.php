<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class VacationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'management_name' => $this->employeeOfVacation?->job?->management?->name,
            'vacation_employee_id' => $this->vacation_employee_id,
            'vacation_employee_name' => $this->employeeOfVacation->full_name,
            'vacation_type_id' => $this->vacation_type_id,
            'vacation_type_name' => $this->Vacationtype?->name,
            'number_days' => $this->number_days,
            'vacation_from_date' => $this->vacation_from_date,
            'vacation_to_date' => $this->vacation_to_date,
            'alter_employee_id' => $this->alter_employee_id,
            'alter_employee_name' => $this->alterEmployeeOfVacation->full_name,
            'notes' => $this->notes,
            'deactivated_at' => ($this->deactivated_at) ? true : false,
            'created_at' => $this->created_at,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'actions' => [
                'create' => auth()->user()->can('create-vacation'),
                'update' => auth()->user()->can('edit-vacation'),
                'destroy' => auth()->user()->can('delete-vacation'),
                'show' => auth()->user()->can('show-vacation'),
            ],

        ];
    }
}
