<?php

namespace App\Modules\User\Tests\Feature;

use App\Modules\User\Entities\User;
use App\Providers\RouteServiceProvider;
use App\Modules\HR\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\HR\Entities\EmployeeJobInformation;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/users';


    public function test_users_list()
    {
        $response = $this->actingAsWithPermission('list-user')->get($this->baseUrl)
        ->assertStatus(200);
    }

    public function test_add_users()
    {
        $user = User::factory()->raw();
        $response = $this->actingAsWithPermission('create-user')->postJson($this->baseUrl, $user);
        $response->assertStatus(201);
    }

    public function test_user_show()
    {
        $user = User::factory()->create();
        $response = $this->actingAsWithPermission('list-user')->get($this->baseUrl.'/'.$user->id)
        ->assertStatus(200);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $update = [
            "employee_id"=>$user->employee_id,
            "employee_number"=>$user->employee_number ,
            "password"=>"Pass@123" ,
            "password_confirmation"=>"Pass@123" ,
        ];
        $response = $this->actingAsWithPermission('edit-user')->patchJson($this->baseUrl.'/'.$user->id, $update);
        $response->assertStatus(200);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAsWithPermission('delete-user')->delete($this->baseUrl.'/'.$user->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
