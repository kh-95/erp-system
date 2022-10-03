<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\PermissionRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\PermissionRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'permission_number' => $this->faker->randomNumber(5, false),
            'date' => $this->faker->date,
            'from' => $this->faker->time,
            'to' => $this->faker->time,
            'from_duration' => $this->faker->randomElement(PermissionRequest::DURATION),
            'to_duration' => $this->faker->randomElement(PermissionRequest::DURATION),
            'type' => $this->faker->randomElement(PermissionRequest::TYPES),
            'hr_notes' => $this->faker->paragraph(),
            'direct_manager_status' => $this->faker->randomElement(PermissionRequest::MANAGER_STATUSES),
            'hr_status' => $this->faker->randomElement(PermissionRequest::HR_STATUSES),
            'employee_id' => Employee::factory()->create(),
        ];
    }
}
