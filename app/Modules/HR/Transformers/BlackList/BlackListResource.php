<?php

namespace App\Modules\HR\Transformers\BlackList;

use Illuminate\Http\Resources\Json\JsonResource;

class BlackListResource extends JsonResource
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
            'full_name' => $this->full_name,
            'reason'=>$this->reason,
            'type' => $this->type,
            'employee_type' => $this->employee_type,
            'created_at' => $this->created_at->toDateTimeString(),
            'actions' => [
                'create' => auth()->user()->can('create-hr_black_lists'),
                'update' => auth()->user()->can('edit-hr_black_lists'),
                'destroy' => auth()->user()->can('delete-hr_black_lists'),
                'show' => auth()->user()->can('show-hr_black_lists'),
            ]

        ];
    }
}
