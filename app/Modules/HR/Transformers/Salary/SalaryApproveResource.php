<?php

namespace App\Modules\HR\Transformers\Salary;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryApproveResource extends JsonResource
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
            'is_paid' => $this->is_paid,
            'is_signed' => $this->is_signed,
            'month' => \Carbon\Carbon::parse($this->month)->format('Y-m'),
        ];
    }
}
