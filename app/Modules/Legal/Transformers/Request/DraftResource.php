<?php

namespace App\Modules\Legal\Transformers\Request;

use Illuminate\Http\Resources\Json\JsonResource;

class DraftResource extends JsonResource
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
            'management' => $this->job?->management?->name,
            'employee' => $this->employee?->full_name,
            'request_subject' => $this->request_subject,
            'request_text' => $this->request_text,
            'status' => $this->status,
            'type'=> $this->type,
            'created_at' => $this->created_at

        ];


    }
}
