<?php

namespace App\Modules\HR\Rules\PermissionRequests;

use App\Modules\Governance\Entities\Meeting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class MeetingCheckRule implements Rule
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
        $meeting = Meeting::where('start_at', '>=', Carbon::parse($this->date . $this->from . $this->from_duration))
            ->where('end_at', '<=', Carbon::parse($this->date . $value . $this->to_duration))->whereHas('attendances', function ($q) {
                $q->where('employee_id', auth()->user()->employee?->id);
                $q->whereIn('status', ['pending', 'accepted']);
            })
            ->first();
        if ($meeting) {
            return false;
        }
        return true;
    }


    public
    function message(): string
    {
        return trans('hr::messages.permission_requests.this_meeting_time_taken');
    }
}
