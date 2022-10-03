<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryApproveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\SalaryApprove::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'month' =>  $this->faker->date(),
            'is_signed' => $this->faker->randomElement([true, false]),
            'is_paid' => $this->faker->randomElement([true, false]),
            'added_by_id' => Employee::factory()->create()->id

        ];
    }
}
