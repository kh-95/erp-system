<?php

namespace App\Modules\HR\Database\Seeders;

use App\Modules\HR\Entities\Allowance;
use App\Modules\HR\Entities\AttendanceFingerprint;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\Nationality;
use App\Modules\HR\Entities\PermissionRequest;
use App\Modules\HR\Entities\Salary;
use App\Modules\HR\Entities\SalaryApprove;
use App\Modules\HR\Entities\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\HR\Entities\VacationType;
use App\Modules\HR\Entities\Vacation;
use App\Modules\HR\Entities\Resignation;


class HRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Nationality::factory(5)->create();
        VacationType::factory(5)->create();
        Salary::factory(5)->create();
        Allowance::factory()->count(5)->create();
        Management::factory(5)->create();
        Job::factory(5)->create();
        SalaryApprove::factory(12)->create();
        EmployeeJobInformation::factory(5)->create();
        $this->call(EmployeeTableSeeder::class);
        AttendanceFingerprint::factory(100)->create();
        //PermissionRequest::factory(100)->create();
        Vacation::factory(5)->create();
        Resignation::factory(5)->create();
        Setting::factory(1)->create();
    }
}
