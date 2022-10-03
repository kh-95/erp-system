<?php

namespace App\Modules\HR\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'is_active' => (boolean)$this->is_active,
            'added_by' => EmployeeResource::make($this->whenLoaded('addedBy')),
            'management' => ManagementResource::make($this->whenLoaded('management')),
            'score' => number_format($this->score, 2, '.', ''),
            'actions' => [
                'create' => auth()->user()->can('create-hr_item'),
                'update' => auth()->user()->can('edit-hr_item'),
                'destroy' => auth()->user()->can('delete-hr_item'),
                'show' => auth()->user()->can('show-hr_item')
            ]
        ];
    }
}
