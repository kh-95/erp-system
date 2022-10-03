<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\Governance\Entities\Meeting;
use App\Modules\HR\Entities\Setting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class LeaveTimeRule implements Rule
{

    private $to_duration;

    public function __construct($to_duration)
    {
        $this->to_duration = $to_duration;

    }

    public function passes($attribute, $value): bool
    {
        $setting = Setting::first();
//        $attend_time = isset($setting) && isset($setting->attend_time) ? $setting->attend_time : '08:00';
        $leave_time = isset($setting) && isset($setting->leave_time) ? $setting->leave_time : '17:00';
        $leave_time = Carbon::parse($leave_time)->format('H:i');
        $to_date = Carbon::parse($value . $this->to_duration)->format('H:i');

        if ($leave_time < $to_date) {
            return false;
        }
        return true;
    }


    public
    function message(): string
    {
        return trans('hr::messages.permission_requests.less_than_attend_time');
    }
}
