<?php

namespace App\Modules\HR\Transformers;

use App\Modules\User\Transformers\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BonusResource extends JsonResource
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
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'management' => ManagementResource::make($this->whenLoaded('management')),
            'employee' => EmployeeResource::make($this->whenLoaded('employee')),
            'action_type' => $this->action_type,
            'duration_type' => $this->duration_type,
            'amount' => number_format($this->amount, 4, '.', ''),
            'duration' => number_format($this->duration, 2, '.', ''),
            'notes' => $this->notes,
            'is_active' => (boolean)$this->is_active,
            'status' => $this->status,
            'applicable_at' => $this->applicable_at,
            'created_at' => $this->created_at_date,
            'actions' => [
                'create' => auth()->user()->can('create-hr_deduct_bonuses'),
                'update' => auth()->user()->can('edit-hr_deduct_bonuses'),
                'show' => auth()->user()->can('show-hr_deduct_bonuses'),
                'bonus_status' => auth()->user()->can('bonusStatus-hr_deduct_bonuses'),

            ]
        ];
    }
}
