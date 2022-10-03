<?php

namespace App\Modules\Secretariat\Transformers\Message;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\HR\Transformers\EmployeeResource;

class SpecialistResource extends JsonResource
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
            'id' => $this->id,
            'management' => $this->management_id,
            'employee' => $this->employee_id,
        ];
    }
}
