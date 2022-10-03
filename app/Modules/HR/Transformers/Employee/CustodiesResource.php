<?php

namespace App\Modules\HR\Transformers\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class CustodiesResource extends JsonResource
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
            'custodies' => $this->custodies ,
        ];
    }
}
