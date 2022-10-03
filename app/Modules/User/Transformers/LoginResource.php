<?php

namespace App\Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'identification_number' => $this->identification_number,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'identity_date' => $this->identity_date,
            'identity_source' => $this->identity_source,
            'date_of_birth' => $this->date_of_birth,
            'marital_status' => $this->marital_status,
            'email' => $this->email,
            'gender' => $this->gender,
            'qualification' => $this->qualification,
            'address' => $this->address,
        ];
    }
}
