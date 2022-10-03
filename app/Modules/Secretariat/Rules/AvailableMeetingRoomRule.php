<?php

namespace App\Modules\Secretariat\Rules;

use App\Modules\Secretariat\Entities\MeetingRoom;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AvailableMeetingRoomRule implements Rule
{
    private ?MeetingRoom $meetingRoom;
    private ?int $duration;
    private $dateTime;

    public function __construct(?int $meetingRoomId, ?int $duration, $dateTime)
    {
        $this->dateTime = $dateTime;
        $this->setMeetingRoom($meetingRoomId);
        $this->duration = $duration;
    }

    public function passes($attribute, $value) :bool
    {
        $date = Carbon::create($this->dateTime);
        $meetings = $this->roomMeetings($date);
        foreach ($meetings as $meeting) {
            if (
                $date->between($meeting->meeting_date, $meeting->meeting_date->addMinutes($meeting->meeting_duration)) ||
                $date->addMinutes($this->duration)->between($meeting->meeting_date, $meeting->meeting_date->addMinutes($meeting->meeting_duration))
            ) {
                return false;
            }
        }
        return true;
    }

    private function roomMeetings($date)
    {
        return $this->meetingRoom
            ->meetings()
            ->whereDate('meeting_date', $date)
            ->get();
    }

    private function setMeetingRoom($id)
    {
        $this->meetingRoom = MeetingRoom::find($id);
    }

    public function message() :string
    {
        return 'message';
    }
}
