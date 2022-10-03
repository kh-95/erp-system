<?php

namespace App\Modules\Secretariat\Http\Repositories\MeetingRooms;

use App\Modules\Secretariat\Entities\MeetingRoom;
use App\Repositories\CommonRepository;

class MeetingRoomRepository extends CommonRepository implements MeetingRoomRepositoryInterface
{
    public function filterColumns()
    {
        return [
            'id',
            'name',
        ];
    }

    public function model()
    {
        return MeetingRoom::class;
    }
}
