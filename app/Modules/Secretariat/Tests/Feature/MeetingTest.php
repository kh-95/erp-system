<?php

namespace App\Modules\Secretariat\Tests\Feature;

use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Entities\MeetingRoom;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/meetings';

    public function test_user_can_list_meetings()
    {
        Meeting::factory()->count(10)->create();
        $this->actingAsWithPermission('list-meeting')->json('GET', $this->baseUrl)
            ->assertStatus(200);
    }

    public function test_user_can_create_meeting()
    {
        $meeting = Meeting::factory()->raw();
        $meeting['date'] = $this->faker->date('d-m-Y');
        $meeting['time'] = $this->faker->time('h:i');
        $time_format = ["AM", "PM"];
        $meeting['time_format'] = $time_format[array_rand($time_format)];
        $employees = Employee::factory()->count(4)->create();
        $meeting['employees'] = $employees->pluck('id')->toArray();
        $contentArray = [
            [
                'content' => $this->faker->sentence
            ],
            [
                'content' => $this->faker->sentence
            ]
        ];
        $meeting['discussion_points'] = $contentArray;
        $meeting['decisions'] = $contentArray;

        $this->actingAsWithPermission('create-meeting')->json('POST', $this->baseUrl, $meeting)
            ->assertStatus(200);
    }

    public function test_user_can_update_meeting()
    {
        $meeting = Meeting::factory()->create();
        $data = Meeting::factory()->raw();

        $this->actingAsWithPermission('edit-meeting')->json( 'PUT', $this->baseUrl . '/' . $meeting->id, $data)
            ->assertStatus(200);
    }

    public function test_user_can_show_meeting()
    {
        $meeting = Meeting::factory()->create();
        $this->actingAsWithPermission('list-meeting')->json( 'GET', $this->baseUrl . '/' . $meeting->id)
            ->assertStatus(200);
    }

    public function test_user_can_delete_meeting()
    {
        $meeting = Meeting::factory()->create();
        $this->actingAsWithPermission('delete-meeting')->json( 'DELETE', $this->baseUrl . '/' . $meeting->id)
            ->assertStatus(200);
    }

}
