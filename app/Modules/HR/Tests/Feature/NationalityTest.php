<?php

namespace App\Modules\HR\Tests\Feature;


use App\Modules\HR\Entities\Nationality;
use App\Providers\RouteServiceProvider;
use App\Modules\HR\Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;



class NationalityTest extends TestCase
{

    use RefreshDatabase;
    protected static $migrationRun = false;

    public function test_nationalities_list()
    {
        $response = $this->actingAsWithPermission('list-nationality')->get(RouteServiceProvider::ROUTE_PREFIX. '/nationalities')
                            ->assertStatus(200);
    }

    public function test_add_nationality()
    {
        $nationality = Nationality::factory()->raw();
        $response = $this->actingAsWithPermission('create-nationality')->postJson(RouteServiceProvider::ROUTE_PREFIX . '/nationalities', $nationality);
        $response->assertStatus(200);
    }

    public function test_show_nationality()
    {
        $nationality = Nationality::factory()->create();
        $response = $this->actingAsWithPermission('list-nationality')->get(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/' . $nationality->id);
        $response->assertStatus(200);
    }

    public function test_update_nationality()
    {
        $nationality = Nationality::factory()->create();
        $alter = Nationality::factory()->raw();
        $response = $this->actingAsWithPermission('edit-nationality')->patchJson(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/' . $nationality->id, $alter);
        $response->assertStatus(200);
    }

    public function test_delete_nationality()
    {
        $nationality = Nationality::factory()->create();
        $response = $this->actingAsWithPermission('delete-nationality')->delete(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/' . $nationality->id);
        $response->assertStatus(200);
    }

    public function test_nationalities_droplist()
    {
        $response = $this->actingAsWithPermission('list-nationality')->get(RouteServiceProvider::ROUTE_PREFIX. '/nationalities/get_list')
                            ->assertStatus(200);
    }

    public function test_togglestatus_nationality()
    {
        $nationality = Nationality::factory()->create();
        $response = $this->actingAsWithPermission('edit-nationality')->get(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/toggle_status/' . $nationality->id);
        $response->assertStatus(200);
    }

    public function test_onlytrashed_nationality()
    {
        $nationality = Nationality::factory()->create();
        $this->actingAsWithPermission('delete-nationality')->delete(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/' . $nationality->id);

        $response = $this->actingAsWithPermission('archive-nationality')->get(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/only_trashed');
        $response->assertStatus(200);
    }

    public function test_restore_nationality()
    {
        $nationality = Nationality::factory()->create();
        $this->actingAsWithPermission('delete-nationality')->delete(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/' . $nationality->id);

        $response = $this->actingAsWithPermission('archive-nationality')->get(RouteServiceProvider::ROUTE_PREFIX . '/nationalities/restore/'.$nationality->id);
        $response->assertStatus(200);
    }
}
