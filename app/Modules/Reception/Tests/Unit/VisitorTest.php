<?php

namespace App\Modules\Reception\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\Visitor;
use App\Providers\RouteServiceProvider;

class VisitorTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private $basUrl = RouteServiceProvider::ROUTE_PREFIX.'/visitor/';

    public function test_create_visitor()
    {
        $visitorData = ['name' => $this->faker->randomLetter(20), 'identity_number' => rand(111111, 999999)];
        $response = $this->actingAsWithPermission('create-visit')->postJson($this->basUrl.'visit/'.Visit::factory()->create()->id, $visitorData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    public function test_edit_visitor()
    {
        $visitorData = ['name' => $this->faker->randomLetter(20), 'identity_number' => rand(111111, 999999)];
        $response = $this->actingAsWithPermission('create-visit')->putJson($this->basUrl.Visitor::factory()->create()->id, $visitorData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    public function test_delete_visitor()
    {
        $this->test_create_visitor();
        $visitor  = Visitor::factory()->create()->id;
        $response = $this->actingAsWithPermission('delete-visit')->deleteJson($this->basUrl.$visitor);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

}
