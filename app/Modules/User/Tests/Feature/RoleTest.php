<?php

namespace App\Modules\User\Tests\Feature;

use App\Modules\User\Entities\Permission;
use App\Modules\User\Entities\Role;
use App\Providers\RouteServiceProvider;
use App\Modules\HR\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private string $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/roles';

    public function test_list_roles()
    {
        Role::factory()->count(10)->create();
        $response = $this->actingAsWithPermission('list-role')->json('GET', $this->baseUrl);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'data' => [
                'roles' => [
                    [
                        "id",
                        "name",
                        "slug",
                        "status",
                        "usersCount",
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

    public function test_user_can_create_role()
    {
        $permission = Permission::factory()->create();
        $data = [
            "name" => $this->faker->name,
            "slug" => $this->faker->name,
            "permissions" => [
                $permission->id
            ],
        ];

        $this->actingAsWithPermission('create-role')->json('POST', $this->baseUrl, $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                "code",
                "data" => [
                    'id',
                    'name',
                    'slug',
                    'status',
                    'usersCount',
                    'permissions' => [
                        [
                            'id' ,
                            'name',
                            'slug'
                        ]
                    ]
                ],
            ]);
    }

    public function test_required_fields_for_create_role()
    {
        $this->actingAsWithPermission('create-role')->json('POST', $this->baseUrl)
            ->assertStatus(422)
            ->assertJsonStructure([
                "code",
                "errors" => [
                    "name" => [

                    ],
                    "slug" => [

                    ],
                    "permissions" => [

                    ]
                ]
            ]);
    }

    public function test_user_can_update_role()
    {
        $role = Role::factory()->create();

        $name = $this->faker->name;
        $slug = $this->faker->name;
        $payload = [
            "name" => $name,
            "slug" => $slug,
        ];

        $this->actingAsWithPermission('edit-role')->json('PUT', $this->baseUrl .'/' . $role->id , $payload)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "data" => [
                    "id" => $role->id,
                    "name" => $name,
                    "slug" => $slug,
                ],
            ]);
    }

    public function test_user_can_delete_role()
    {
        $role = Role::factory()->create();

        $this->actingAsWithPermission('delete-role')->json( 'DELETE', $this->baseUrl .'/' . $role->id)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "data" => "deleted",
            ]);
    }

}
