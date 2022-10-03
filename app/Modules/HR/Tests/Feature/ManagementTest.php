<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use App\Modules\Hr\Entities\Management;

class ManagmentTest extends TestCase
{
    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/managements/';
    use RefreshDatabase;

    public function test_managements_list()
    {
        $this->actingAsWithPermission('list-management')->get($this->baseUrl)->assertStatus(200);
    }

    public function test_add_management()
    {
        $this->actingAsWithPermission('create-management')->postJson($this->baseUrl, Management::factory()->raw())->assertStatus(200);
    }

    public function test_show_management()
    {
        $response = $this->actingAsWithPermission('list-management')->get($this->baseUrl . Management::factory()->create()->id)->assertStatus(200);
    }

    public function test_update_management()
    {
        $management = Management::factory()->create();
        $update = [
            "name" => 'test update management',
            "parent_id" => "",
            "image" => "",
            'description' => $management->description
        ];
        $this->actingAsWithPermission('edit-management')->patchJson($this->baseUrl .  $management->id, $update)->assertStatus(200);
    }

    public function test_delete_management()
    {
        $this->actingAsWithPermission('delete-management')->delete($this->baseUrl .  Management::factory()->create()->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_managements_droplist()
    {
        $this->actingAsWithPermission('list-management')->get($this->baseUrl . 'list')->assertStatus(200);
    }

    public function test_togglestatus_management()
    {
        $this->actingAsWithPermission('edit-management')->get($this->baseUrl . 'deactivated/' . Management::factory()->create()->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_archive_management()
    {
        $this->actingAsWithPermission('delete-management')->delete($this->baseUrl . Management::factory()->create()->id);
        $this->actingAsWithPermission('archive-management')->get($this->baseUrl . 'archive')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_restore_management()
    {
        $management = Management::factory()->create();
        $response = $this->actingAsWithPermission('delete-management')->delete($this->baseUrl . $management->id);
        $response = $this->actingAsWithPermission('archive-management')->get($this->baseUrl . 'restore/' . $management->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
