<?php

namespace App\Modules\HR\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AllowanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Allowance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name
        ];
    }
}

