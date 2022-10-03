<?php
namespace App\Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\HR\Tests\TestCase;
use App\Providers\RouteServiceProvider ;
use App\Modules\HR\Entities\Management;

class ManagmentTest extends TestCase
{
    use RefreshDatabase ;
    private $baseUrl   = RouteServiceProvider::ROUTE_PREFIX.'/managements/';

    public function test_managements_list()
    {
        $response = $this->actingAsWithPermission('list-management')->get($this->baseUrl)
        ->assertStatus(200);
    }
    public function test_add_management()
    {
        $management = Management::factory()->raw();
        $response = $this->actingAsWithPermission('create-management')->postJson($this->baseUrl, $management);
        $response->assertStatus(200);
    }
    public function test_show_management()
    {
        $management = Management::factory()->create();
        $response = $this->actingAsWithPermission('list-management')->get( $this->baseUrl . $management->id);
        $response->assertStatus(200);
    }
    public function test_update_management()
    {
        $management = Management::factory()->create();
        $update       = Management::factory()->raw();
        $response    = $this->actingAsWithPermission('edit-management')->patchJson($this->baseUrl .  $management->id, $update);
        $response->assertStatus(200);
    }
    public function test_delete_management()
    {
        $management = Management::factory()->create();
        $response = $this->actingAsWithPermission('delete-management')->delete($this->baseUrl .  $management->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
    public function test_managements_droplist()
    {

        $response = $this->actingAsWithPermission('list-management')->get($this->baseUrl.'list')
        ->assertStatus(200);
    }

    public function test_togglestatus_management()
    {
        $management = Management::factory()->create();
        $response = $this->actingAsWithPermission('edit-management')->get($this->baseUrl . 'deactivated/' . $management->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }


}
