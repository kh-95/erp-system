<?php

namespace App\Modules\Secretariat\Transformers\Message;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;

class MessageResource extends JsonResource
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
            'message_number' => $this->message_number,
            'source' => $this->source,
            'message_date' => $this->message_date,
            'message_recieve_date' => $this->message_recieve_date,
            'message_body' => $this->message_body,
            'claimant' =>  new ClaimantResource($this->whenLoaded('claimant')),
            'legal' =>  new LegalResource($this->whenLoaded('legal')),
            'specialist' =>  new SpecialistResource($this->whenLoaded('specialist')),
            'defendant' =>  new DefendantResource($this->whenLoaded('defendant')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),

        ];
    }
}
