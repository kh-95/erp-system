<?php

namespace App\Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'permission_module' => $this->module,
            'status' => $this->deactivited_at === null ? trans('common.activated') : trans('common.deactivated'),
        ];
    }
}

