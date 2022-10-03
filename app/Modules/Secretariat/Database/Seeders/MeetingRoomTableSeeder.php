<?php

namespace App\Modules\Secretariat\Database\Seeders;

use App\Modules\Secretariat\Entities\MeetingRoom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MeetingRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $rooms = [
            'غرفة التدريب 1',
            'غرفة التدريب 2',
            'غرفة التدريب 3',
            'غرفة الاجتماعات',
        ];

        foreach ($rooms as $room) {
            MeetingRoom::factory()->create([
               'name' => $room
            ]);
        }
    }
}
