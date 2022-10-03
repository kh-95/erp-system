<?php

namespace App\Modules\RiskManagement\Transformers\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at_date,
            'terms' => NotificationTermResource::collection($this->whenLoaded('terms')),
            'actions' => [
                'create' => auth()->user()->can('create-rm_notifications'),
                'update' => auth()->user()->can('edit-rm_notifications'),
                'destroy' => auth()->user()->can('delete-rm_notifications'),
                'show' => auth()->user()->can('show-rm_notifications'),
            ]
        ];
    }
}
