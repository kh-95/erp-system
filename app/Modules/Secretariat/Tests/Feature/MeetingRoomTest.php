<?php

namespace App\Modules\Secretariat\Tests\Feature;

use App\Modules\Secretariat\Entities\MeetingRoom;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingRoomTest extends TestCase
{
    use RefreshDatabase;

    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/meeting_rooms';

    public function test_user_can_list_rooms()
    {
        MeetingRoom::factory()->count(10)->create();
        $this->actingAsWithPermission('list-meetingRoom')->json('GET', $this->baseUrl)
            ->assertStatus(200)
            ->assertJsonStructure([
            'code',
            'data' => [
                [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    public function test_user_can_create_room()
    {
        $room = MeetingRoom::factory()->raw();
        $this->actingAsWithPermission('create-meetingRoom')->json( 'POST', $this->baseUrl, $room)
            ->assertStatus(201);
    }

    public function test_user_can_update_room()
    {
        $room = MeetingRoom::factory()->create();
        $data = MeetingRoom::factory()->raw();
        $this->actingAsWithPermission('edit-meetingRoom')->json( 'PUT', $this->baseUrl . '/' . $room->id, $data)
            ->assertStatus(200);
    }

    public function test_user_can_delete_room()
    {
        $room = MeetingRoom::factory()->create();
        $this->actingAsWithPermission('delete-meetingRoom')->json( 'DELETE', $this->baseUrl . '/' . $room->id)
            ->assertStatus(200);
    }

}
