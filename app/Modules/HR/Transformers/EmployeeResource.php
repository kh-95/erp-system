<?php

namespace App\Modules\HR\Transformers;

use App\Http\Resources\JobInformationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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
            'nationality' => new NationalityResource($this->whenLoaded('nationality')),
            'jobInformation' => new JobInformationResource($this->whenLoaded('jobInformation')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'allowances' => AllowanceResource::collection($this->whenLoaded('allowances')),
            'custodies' => CustodyResource::collection($this->whenLoaded('custodies')),
            'actions' => [
                'create' => auth()->user()->can('create-hr_employees'),
                'update' => auth()->user()->can('edit-hr_employees'),
                'show' => auth()->user()->can('show-hr_employees'),
            ]
        ];
    }
}
