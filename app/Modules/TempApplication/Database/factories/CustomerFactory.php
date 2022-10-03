<?php

namespace App\Modules\TempApplication\Database\Factories;

use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\TempApplication\Entities\Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application' => $this->faker->randomElement(['jack', 'maeak']),
            'name' => $this->faker->name,
            'indentity' => $this->faker->numerify('##########'),
            'mobile' => $this->faker->numerify('###########'),
            'contract_number'=>rand(111111, 999999),
        ];


    }
}
