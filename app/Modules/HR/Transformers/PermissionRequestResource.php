<?php

namespace App\Modules\HR\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionRequestResource extends JsonResource
{
    public function toArray($request)
    {
        //TODO: get from setting
        $rasid_start_month_date = 60;
        $rasid_permission_duration = 90;

        return [
            'id' => $this->id,
            'permission_number' => $this->permission_number,
            'employee' => $this->employee?->full_name,
            'management' => $this->employee?->job?->management?->name,
            'date' => $this->date,
            'from' => Carbon::parse($this->from)->format('H:i a'),
            'to' => Carbon::parse($this->to)->format('H:i a'),
            'direct_manager_status' => $this->direct_manager_status,
            'note' => $this->notes,
            'manager_notes' => $this->manager_notes,

            // if the user is manager
//            'permission_duration' => Carbon::parse($this->to)->diffInMinutes(Carbon::parse($this->from)),
            'permission_duration' => $this->permission_duration,
            'total_permissions_per_month' => $rasid_start_month_date,
            'rest_duration_for_permissions' => max($rasid_permission_duration - $this->allDonePermissionRequestsDuration, 0)
        ];
    }
}
