<?php

namespace App\Modules\Secretariat\Transformers;
use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

       $timimg = $this->appointment_date?->format('H:i') > "12:00" ? "PM" : "AM";

        return [
            'id' => $this->id,
            'title' => $this->title,
            'appointment_date' => $this->appointment_date->format('d/m/Y'),
            'appointment_time' =>$this->appointment_date->format('H:i'). $timimg,
            'details'=>$this->details,
            'employee_id'=>$this->employee?->full_name,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'actions' => [
                'create' => auth()->user()->can('create-secr_appointments'),
                'update' => auth()->user()->can('edit-secr_appointments'),
                'show' => auth()->user()->can('show-secr_appointments'),
                'destroy' => auth()->user()->can('destroy-secr_appointments'),

            ]
        ];
    }
}
