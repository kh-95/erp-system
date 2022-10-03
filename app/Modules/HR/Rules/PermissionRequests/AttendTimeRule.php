<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\Governance\Entities\Meeting;
use App\Modules\HR\Entities\Setting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AttendTimeRule implements Rule
{

    private $from_duration;

    public function __construct($from_duration)
    {
        $this->from_duration = $from_duration;

    }

    public function passes($attribute, $value): bool
    {
        $setting = Setting::first();
        $attend_time = isset($setting) && isset($setting->attend_time) ? $setting->attend_time : '08:00';
        $leave_time = isset($setting) && isset($setting->leave_time) ? $setting->leave_time : '17:00';
        $leave_time = Carbon::parse($leave_time)->format('H:i');
        $from_date = Carbon::parse($value . $this->from_duration)->format('H:i');

        if ($from_date >= $attend_time && $leave_time > $from_date ) {
            return true;
        }
        return false;
    }


    public
    function message(): string
    {
        return trans('hr::messages.permission_requests.less_than_attend_time');
    }
}
