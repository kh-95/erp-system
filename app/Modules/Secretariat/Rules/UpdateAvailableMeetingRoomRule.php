<?php

namespace App\Modules\Secretariat\Rules;

use App\Modules\Secretariat\Entities\MeetingRoom;
use App\Modules\Secretariat\Entities\Meeting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class UpdateAvailableMeetingRoomRule implements Rule
{
    private ?MeetingRoom $meetingRoom;
    private ?int $duration;
    private $dateTime;
    private $meeting_id;

    public function __construct(?int $meetingRoomId, ?int $duration, $dateTime, $meeting_id)
    {
        $this->dateTime = $dateTime;
        $this->setMeetingRoom($meetingRoomId);
        $this->duration = $duration;
        $this->meeting_id = $meeting_id;
    }

    public function passes($attribute, $value) :bool
    {
        $date = Carbon::create($this->dateTime);
        $meetings = $this->roomMeetings($date, $this->meeting_id);
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

    private function roomMeetings($date, $meeting_id)
    {
        $meeting = Meeting::find($meeting_id);
        return $this->meetingRoom
            ->meetings()
            ->whereDate('meeting_date', $date)
            ->whereDate('meeting_date', '!=', $meeting->meeting_date)
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
