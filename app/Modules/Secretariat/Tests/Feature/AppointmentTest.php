<?php

namespace App\Modules\Secretariat\Tests\Feature;

use App\Modules\Secretariat\Entities\Appointment;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Secretariat\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;



class AppointmentTest extends TestCase
{

    use RefreshDatabase,WithFaker;
    protected static $migrationRun = false;

    public function test_appointments_list()
    {
        $response = $this->actingAsWithPermission('list-appointment')->get(RouteServiceProvider::ROUTE_PREFIX. '/appointments')
                            ->assertStatus(200);
    }

   public function test_add_appointment()
    {
        $appointment = Appointment::factory()->raw();
        $appointment['date'] = $this->faker->date('d-m-Y');
        $appointment['time'] = $this->faker->time('h:i');
        $time_format = ["AM", "PM"];
        $appointment['time_format'] = $time_format[array_rand($time_format)];
        $response = $this->actingAsWithPermission('create-appointment')->postJson(RouteServiceProvider::ROUTE_PREFIX . '/appointments', $appointment);
        $response->assertStatus(200);
    }

     public function test_show_appointment()
    {
        $appointment = Appointment::factory()->create();
        $response = $this->actingAsWithPermission('list-appointment')->get(RouteServiceProvider::ROUTE_PREFIX . '/appointments/' . $appointment->id);
        $response->assertStatus(200);
    }

   public function test_update_appointment()
    {
        $appointment = Appointment::factory()->create();
        $alter = Appointment::factory()->raw(); 
        $alter['date'] = $this->faker->date('d-m-Y');
        $alter['time'] = $this->faker->time('h:i');
        $time_format = ["AM", "PM"];
        $alter['time_format'] = $time_format[array_rand($time_format)];
        $response = $this->actingAsWithPermission('edit-appointment')->patchJson(RouteServiceProvider::ROUTE_PREFIX . '/appointments/' . $appointment->id, $alter);
        $response->assertStatus(200);
    }

     public function test_delete_appointment()
    {
        $appointment = Appointment::factory()->create();
        $response = $this->actingAsWithPermission('delete-appointment')->delete(RouteServiceProvider::ROUTE_PREFIX . '/appointments/' . $appointment->id);
        $response->assertStatus(200);
    }

    public function test_onlytrashed_appointment()
    {
        $appointment = Appointment::factory()->create();
        $this->actingAsWithPermission('delete-appointment')->delete(RouteServiceProvider::ROUTE_PREFIX . '/appointments/' . $appointment->id);

        $response = $this->actingAsWithPermission('archive-appointment')->get(RouteServiceProvider::ROUTE_PREFIX . '/appointments/only_trashed');
        $response->assertStatus(200);
    }

    public function test_restore_appointment()
    {
        $appointment = Appointment::factory()->create();
        $this->actingAsWithPermission('delete-appointment')->delete(RouteServiceProvider::ROUTE_PREFIX . '/appointments/' . $appointment->id);

        $response = $this->actingAsWithPermission('archive-appointment')->get(RouteServiceProvider::ROUTE_PREFIX . '/appointments/restore/'.$appointment->id);
        $response->assertStatus(200);
    }
}
