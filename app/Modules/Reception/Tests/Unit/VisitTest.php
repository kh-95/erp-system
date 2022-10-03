<?php

namespace App\Modules\Reception\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\Visitor;
use App\Providers\RouteServiceProvider;

class VisitTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private $basUrl = RouteServiceProvider::ROUTE_PREFIX.'/visit/';

    public function test_create_visit()
    {
        $response = $this->actingAsWithPermission('create-visit')->postJson($this->basUrl, $this->createVisitData());
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    private function createVisitData(){
        $visit = Visit::factory()->raw();
        $visit['date'] = '2022-08-30';
        $visit['time'] = '02:00';
        $visit['time_type'] = 'pm';
        $visitor = Visitor::factory()->raw();
        $visit['visitors'] = [$visitor];
        $visit['employees'] = [["employee_id" => Employee::factory()->create()->id]];
        return $visit;
    }

    public function test_update_visit(){
        $this->test_create_visit();
        $visitData = $this->createVisitData();
        $visit  = Visit::orderBy('id','desc')->first();
        $response  = $this->actingAsWithPermission('edit-visit')->putJson($this->basUrl.$visit->id, $visitData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    public function test_show(){
        $this->test_create_visit();
        $visit  = Visit::orderBy('id','desc')->first();
        $response = $this->actingAsWithPermission('list-visit')->getJson($this->basUrl.$visit->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    public function test_update_status(){
        $this->test_create_visit();
        $visit  = Visit::orderBy('id','desc')->first();
        $response = $this->actingAsWithPermission('edit-visit')->putJson(RouteServiceProvider::ROUTE_PREFIX.'/visitStatus/'.$visit->id,["status" => "underway"]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
        }

    public function test_show_visits(){
        $response = $this->actingAsWithPermission('list-visit')->getJson($this->basUrl);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

    public function test_delete_visit(){
        $this->test_create_visit();
        $visit  = Visit::orderBy('id','desc')->first();
        $response = $this->actingAsWithPermission('delete-visit')->deleteJson($this->basUrl.$visit->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);
    }

}
