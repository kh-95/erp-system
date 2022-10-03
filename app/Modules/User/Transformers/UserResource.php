<?php

namespace App\Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'image' => $this->image,
            'full_name' => $this->employee->full_name,
            'management' => $this->employee?->job?->management?->name,
            'job' => $this->employee?->job?->name,
            'created_at' => $this->created_at?->format('d-m-Y'),
            'status' => $this->status,
            'token' => $this->when($this->token,$this->token),
            'permission_modules' => $this->getAllPermissions()->pluck('module')->unique()->toArray()
        ];
    }
}
