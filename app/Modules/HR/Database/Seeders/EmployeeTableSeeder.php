<?php

namespace App\Modules\HR\Database\Seeders;

use App\Modules\HR\Entities\Allowance;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call("OthersTableSeeder");
    }
}
