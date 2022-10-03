<?php

namespace App\Modules\User\Database\factories;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\User\Entities\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $createEmployeeInfo = EmployeeJobInformation::factory()->create() ;
        return [
            'employee_id' => $createEmployeeInfo->employee_id,
            'employee_number' => $createEmployeeInfo->employee_number,
            'password' => 123456,
            'is_send_otp' => false
        ];
    }
}

