<?php

namespace App\Modules\Finance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class CashRegisterResource extends JsonResource
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
          'tranfer_number' => $this->tranfer_number,
          'date' => $this->date,
          'money' => $this->money,
          'from_register' => $this->from_register,
          'to_register' => $this->to_register,
          'note' => $this->note,
          'bank_id' => $this->bank_id,
          'check_number' => $this->check_number,
          'check_number_date' => $this->check_number_date,
          'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
          'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
