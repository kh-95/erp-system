<?php

namespace App\Modules\User\Transformers;

use App\Transformers\ActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->deactivated_at === null ? trans('common.activated') : trans('common.deactivated'),
            'usersCount' => $this->users_count,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
