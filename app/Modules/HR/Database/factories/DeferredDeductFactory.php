<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeferredDeductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\DeferredDeduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory()->create()->id,
            'net_salary' => $this->faker->numerify('#####'),
            'deducted_amount' => $this->faker->numerify('#####'),
            'deferred_amount' => $this->faker->numerify('#####'),
            'deduction_percentage' => $this->faker->numerify('0.##'),
            'month' =>  $this->faker->date(),

        ];
    }
}
