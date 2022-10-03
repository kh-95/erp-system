<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Salary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'base_salary' => $this->faker->numerify('#####'),
            'gross_salary' => $this->faker->numerify('#####'),
            'net_salary' => $this->faker->numerify('#####'),
            'month' =>  $this->faker->date(),
            'is_signed' => $this->faker->randomElement([true, false]),
            'is_paid' => $this->faker->randomElement([true, false]),
            'employee_id' => Employee::factory()->create()->id,
        ];
    }
}
