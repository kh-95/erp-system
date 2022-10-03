<?php

namespace App\Modules\Reception\Tests\Feature;

use App\Modules\Reception\Entities\ReceptionReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Tests\TestCase;

class ReceptionReportTest extends TestCase
{
    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/reception_report/';
    use RefreshDatabase, WithFaker;

    public function test_reception_report_list()
    {
        $this->actingAsWithPermission('list-reception-report')->get($this->baseUrl)->assertStatus(200);
    }

    public function test_add_reception_report()
    {
        $reception_report = ReceptionReport::factory()->raw();
        $reception_report['date'] = Carbon::now()->format('Y-m-d');
        $reception_report['time'] = "11:00";
        $time_type = ["AM", "PM"];
        $reception_report['time_type'] = $time_type[array_rand($time_type)];
        $this->actingAsWithPermission('create-reception-report')->postJson($this->baseUrl, $reception_report)->assertStatus(200);
    }

    public function test_show_reception_report()
    {
        $this->actingAsWithPermission('list-reception-report')->get($this->baseUrl.ReceptionReport::factory()->create()->id)->assertStatus(200);
    }

    public function test_update_reception_report()
    {
        $reception_report = ReceptionReport::factory()->raw();
        $reception_report['date'] = Carbon::now()->format('Y-m-d');
        $reception_report['time'] = "08:00";
        $time_type = ["AM", "PM"];
        $reception_report['time_type'] = $time_type[array_rand($time_type)];
        $this->actingAsWithPermission('edit-reception-report')->patchJson($this->baseUrl.ReceptionReport::factory()->create()->id, $reception_report)->assertStatus(200);
    }

    public function test_update_status_reception_report()
    {
        $status_type = ["underway","finished","canceled"];
        $status = $status_type[array_rand($status_type)];
        $response = $this->actingAsWithPermission('update-reception-report')->get($this->baseUrl . 'update_status/'.ReceptionReport::factory()->create()->id.'/'.$status);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_delete_reception_report()
    {
        $this->actingAsWithPermission('delete-reception-report')->delete($this->baseUrl .  ReceptionReport::factory()->create()->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_archive_reception_report()
    {
        $this->actingAsWithPermission('delete-reception-report')->delete($this->baseUrl . ReceptionReport::factory()->create()->id);
        $this->actingAsWithPermission('archive-reception-report')->get($this->baseUrl . 'archive')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_restore_reception_report()
    {
        $reception_report = ReceptionReport::factory()->create();
        $response = $this->actingAsWithPermission('delete-reception-report')->delete($this->baseUrl . $reception_report->id);
        $response = $this->actingAsWithPermission('archive-reception-report')->get($this->baseUrl . 'restore/' . $reception_report->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
