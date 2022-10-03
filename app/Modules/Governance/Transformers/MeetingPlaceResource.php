<?php

namespace App\Modules\Governance\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\ActivityResource;



class MeetingPlaceResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'activities'      => ActivityResource::collection($this->whenLoaded('activities')),
            'is_active'       => (bool)$this->is_active,
            'created_at'      => $this->created_at_date ?? "",
            'actions' => [
                'create' => auth()->user()->can('create-meeting_places'),
                'update' => auth()->user()->can('edit-meeting_places'),
                'show' => auth()->user()->can('show-meeting_places'),
                'delete' => auth()->user()->can('delete--meeting_places'),

            ],

        ];
    }
}
