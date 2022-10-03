<?php

namespace App\Modules\HR\Transformers\HoldHarmless;

use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\JobResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HarmlessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee' => EmployeeResource::make($this->whenLoaded('employees')),
            'reason' => $this->reason,
            'note' => $this->note,
            'dm' => HarmlessResource::generateManagementsResponse($this->dm_response, $this->dm_note, $this->dm_rejection_reason),
            'hr' => HarmlessResource::generateManagementsResponse($this->hr_response, $this->hr_note, $this->hr_rejection_reason),
            'it' => HarmlessResource::generateManagementsResponse($this->it_response, $this->it_note, $this->it_rejection_reason),
            'legal' => HarmlessResource::generateManagementsResponse($this->legal_response, $this->legal_note, $this->legal_rejection_reason),
            'finance' => HarmlessResource::generateManagementsResponse($this->finance_response, $this->finance_note, $this->finance_rejection_reason),
            'queue' => $this->queue,
            'created_at' => $this->created_at->format('d-m-y')
        ];
    }

    static private function generateManagementsResponse($management_response, $management_note, $rejection = null){
        switch($management_response){
            case 'pending':
                return ['status' => 'pending'];
                break;
            case 'rejected':
                return ['status' => 'completed', 'response' => 'rejected',
                'rejection_reason' => $rejection,'note' => $management_note];
                break;
            case 'accepted':
                return ['status' => 'completed', 'response' => 'accepted', 'note' => $management_note];
                break;
        }
    }
}
