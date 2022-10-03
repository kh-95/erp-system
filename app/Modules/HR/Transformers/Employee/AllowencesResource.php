<?php

namespace App\Modules\HR\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class AllowencesResource extends JsonResource
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
            'employee_id' => $this->employee_id ,
            'allowances' => $this->allowances 
        ];
    }
}
