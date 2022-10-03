<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->fullname,
            'is_active' => !$this->deactivated_at,
            'is_president' => isset($this->pivot->is_president) ? (bool)$this->pivot->is_president : (bool)$this->pivot->is_manager,
            'job' => $this?->job?->name,
            'status' => $this->when(isset($this->pivot->is_manager),$this->pivot->status)
        ];
    }
}
