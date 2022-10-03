<?php

namespace App\Modules\RiskManagement\Transformers;

use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Transformers\Notification\NotificationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationVendorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'notification' => NotificationResource::make($this->notification),
            'vendor' => VendorResource::make($this->vendor),
            'take_action' => TakenActionResource::make($this->takenAction),
            'take_action_type' => $this->taken_action,
            'created_at'   => $this->created_at_date,
            'updated_at'   => $this->updated_at_date,
            'actions' => [
                'show' => $this->when($this->taken_action == NotificationVendor::WAITING_ACTION, auth()->user()->can('show-rm_vendor_notifications')),
                'takeAction' => $this->when($this->taken_action != NotificationVendor::WAITING_ACTION, auth()->user()->can('takeAction-rm_vendor_notifications')),
            ]
        ];
    }
}
