<?php

namespace App\Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VacationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\VacationType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'number_days' => $this->faker->numerify('##')
        ];
       
    }
}
