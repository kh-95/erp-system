<?php

namespace App\Modules\HR\Tests\Feature;

use App\Modules\HR\Entities\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;

use App\Modules\HR\Tests\TestCase;



class JobTest extends TestCase
{
    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX.'/jobs/';
    use RefreshDatabase ;


    public function test_jobs_list()
    {
        $this->actingAsWithPermission('list-job')->get($this->baseUrl)->assertStatus(200);
    }

    public function test_add_job()
    {
        $this->actingAsWithPermission('create-job')->postJson($this->baseUrl, Job::factory()->raw())->assertStatus(200);
    }

    public function test_show_job()
    {
        $this->actingAsWithPermission('list-job')->get( $this->baseUrl . Job::factory()->create()->id)->assertStatus(200);
    }

    public function test_update_job()
    {
        $job = Job::factory()->create();
        $update = [
            'name'=>'test update job' ,
            'management_id'=>$job->management_id ,
            'description'=>$job->description
        ];
        $this->actingAsWithPermission('edit-job')->patchJson($this->baseUrl.$job->id, $update)->assertStatus(200);
    }

    public function test_delete_job()
    {
        $this->actingAsWithPermission('delete-job')->delete($this->baseUrl .  Job::factory()->create()->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    public function test_job_droplist()
    {


        $response = $this->actingAsWithPermission('list-job')->get($this->baseUrl.'list')
        ->assertStatus(200);

    }

    public function test_togglestatus_job()
    {
        $this->actingAsWithPermission('edit-job')->get($this->baseUrl . 'deactivated/' .Job::factory()->create()->id)
         ->assertStatus(200)
         ->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_archive_job()
    {
        $this->actingAsWithPermission('delete-job')->delete($this->baseUrl . Job::factory()->create()->id);
        $this->actingAsWithPermission('archive-job')->get($this->baseUrl. 'archive')
          ->assertStatus(200)
          ->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_restore_job()
    {
        $job = Job::factory()->create();
        $response = $this->actingAsWithPermission('delete-job')->delete($this->baseUrl . $job->id);
        $response = $this->actingAsWithPermission('archive-job')->get($this->baseUrl. 'restore/'. $job->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
