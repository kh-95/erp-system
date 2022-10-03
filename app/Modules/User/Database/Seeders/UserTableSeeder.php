<?php

namespace App\Modules\User\Database\Seeders;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
       EmployeeJobInformation::create([
            'employee_id' => 1,
            'employee_number' => 123456,
            'receiving_work_date' => now(),
            'job_id' => 1,
            'contract_period' => 3,
            'contract_type' => 'both',
            'salary' => "100",
        ]);
        $user = User::create([
            'employee_id' => 1,
            'employee_number' => 123456,
            'password' => 123456,
            'is_send_otp' => false
        ]);
        $user->assignRole(1);
    }
}
