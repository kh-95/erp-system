<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\Secretariat\Entities\Meeting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AppointmentCheckRule implements Rule
{

    private $date;
    private $from;
    private $from_duration;
    private $to_duration;

    public function __construct($date, $from, $from_duration, $to_duration)
    {
        $this->date = $date;
        $this->from = $from;
        $this->from_duration = $from_duration;
        $this->to_duration = $to_duration;
    }

    public function passes($attribute, $value): bool
    {
        $appointments = Meeting::where('meeting_date', '>=', Carbon::parse($this->date . $this->from . $this->from_duration))
            ->whereHas('employeeMeetings', function ($q) {
                $q->where('employee_id', auth()->id());
                $q->where('rejected_reason', null);
            })
            ->get();

        foreach ($appointments as $appointment) {
            if (Carbon::parse($appointment->meeting_date)->addMinutes($appointment->meeting_duration) <= Carbon::parse($this->date . $value . $this->to_duration)) {
                return false;
            }
        }

        return true;
    }


    public function message(): string
    {
        return trans('hr::messages.permission_requests.this_appointment_time_taken');
    }
}
