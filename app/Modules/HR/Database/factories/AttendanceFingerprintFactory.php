<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\AttendanceFingerprint;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFingerprintFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\AttendanceFingerprint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory()->create(),
            'attended_at' => $this->faker->date,
            'leaved_at' => $this->faker->date,
            'method' => $this->faker->randomElement(AttendanceFingerprint::METHODS),
            'branch' => $this->faker->randomElement(AttendanceFingerprint::BRANCHES),
            'has_vacation' => $this->faker->boolean,
            'has_permission' => $this->faker->boolean,
            'punishment' => $this->faker->randomElement(AttendanceFingerprint::PUNISHMENT),
            'punishment_status' => $this->faker->randomElement(AttendanceFingerprint::PUNISHMENT_STATUS),
            'notes' => $this->faker->paragraph,
        ];
    }
}
