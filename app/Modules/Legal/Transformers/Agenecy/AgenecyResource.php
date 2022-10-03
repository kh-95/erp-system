<?php

namespace App\Modules\Legal\Transformers\Agenecy;

use App\Modules\HR\Transformers\EmployeeResource;
use App\Modules\HR\Transformers\ManagementResource;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenecyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_management' => ManagementResource::make($this->clientManagement),
            'client_employee' => EmployeeResource::make($this->clientEmployee),
            'client_agenecy_as' => $this->client_agenecy_as,
            'previous_agenecy_id' => $this->previous_agenecy_id,
            'agent_management' =>  ManagementResource::make($this->agentManagement),
            'agent_employee' => EmployeeResource::make($this->agentEmployee),
            'agenecy_number' => $this->agenecy_number,
            'country' => $this->country,
            'duration_type' => $this->duration_type,
            'duration' => $this->duration,
            'hijiry_end_date' => $this->hijiry_end_date,
            'milady_end_date' => $this->milady_end_date,
            'agency_type' => AgenecyTypeResource::collection($this->types),
            'agenecy_type_terms' => AgenecyTermResource::collection($this->terms),
            'static_texts' => StaticTextResource::collection($this->staticTexts),
            'updated_at' => $this->updated_at_date_time,
            'created_at' => $this->created_at_date_time,
            'attachments' => AttachmentResource::collection($this->attachments)
        ];
    }
}
