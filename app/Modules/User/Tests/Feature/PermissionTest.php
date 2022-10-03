<?php

namespace App\Modules\User\Tests\Feature;

use App\Modules\User\Entities\Permission;
use App\Providers\RouteServiceProvider;
use App\Modules\HR\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private string $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/permissions';

    public function test_list_permissions()
    {
        Permission::factory()->count(10)->create();
        $response = $this->actingAsWithPermission('list-permission')->json('GET', $this->baseUrl);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'data' => [
                'permissions' => [
                    [
                        "id",
                        "name",
                        "slug"
                    ]
                ],
                'pagination' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                ]
            ]
        ]);
    }

    public function test_user_can_create_permission()
    {
        $data = [
            "name" => $this->faker->name,
            "slug" => $this->faker->name,
        ];
        $this->actingAsWithPermission('create-permission')->json( 'POST', $this->baseUrl, $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                "code",
                "data" => [
                    'id',
                    'name',
                    'slug',
                ],
            ]);
    }

    public function test_required_fields_for_create_permission()
    {
        $this->actingAsWithPermission('create-permission')->json( 'POST', $this->baseUrl)
            ->assertStatus(422)
            ->assertJsonStructure([
                "code",
                "errors" => [
                    "name" => [

                    ],
                    "slug" => [

                    ],
                ]
            ]);
    }

    public function test_user_can_update_permission()
    {
        $permission = Permission::factory()->create();

        $name = $this->faker->name;
        $slug = $this->faker->name;
        $payload = [
            "name" => $name,
            "slug" => $slug,
        ];

        $this->actingAsWithPermission('edit-permission')->json('PUT', $this->baseUrl .'/' . $permission->id , $payload)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "data" => [
                    "id" => $permission->id,
                    "name" => $name,
                    "slug" => $slug,
                ],
            ]);
    }

    public function test_user_can_delete_permission()
    {
        $permission = Permission::factory()->create();

        $this->actingAsWithPermission('delete-permission')->json( 'DELETE', $this->baseUrl .'/' . $permission->id)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "data" => "deleted",
            ]);
    }
}
