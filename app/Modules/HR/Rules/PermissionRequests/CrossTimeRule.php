<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\HR\Entities\PermissionRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CrossTimeRule implements Rule
{

    private $date;
    private $from;
    private $from_duration;
    private $to_duration;
    private $permission_number;

    public function __construct($date, $from, $from_duration, $to_duration, $permission_number = null)
    {
        $this->date = $date;
        $this->from = $from;
        $this->from_duration = $from_duration;
        $this->to_duration = $to_duration;
        $this->permission_number = $permission_number;
    }

    public function passes($attribute, $value): bool
    {
        $permission_request = PermissionRequest::where('employee_id',auth()->user()->employee?->id)
            ->whereDate('date', $this->date)
            ->whereTime('to', '>=', Carbon::parse($this->from . $this->from_duration)->format('H:i'))
            ->whereTime('from', '<=', Carbon::parse($value . $this->to_duration)->format('H:i'))
            ->first();
        if ($permission_request) {
            $this->permission_number = $permission_request->permission_number;

            return false;
        }
        return true;
    }


    public
    function message(): string
    {
        return trans('hr::messages.permission_requests.this_time_taken', ['number' => $this->permission_number]);
    }
}
