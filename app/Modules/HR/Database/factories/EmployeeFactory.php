<?php

namespace App\Modules\HR\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identification_number' => $this->faker->numerify('##########'),
            'first_name' => $this->faker->firstName,
            'second_name' => $this->faker->firstName,
            'third_name' => $this->faker->firstName,
            'last_name' => $this->faker->firstName,
            'phone' => $this->faker->numerify('###########'),
            'identity_date' => $this->faker->date(),
            'identity_source' => $this->faker->name,
            'date_of_birth' => $this->faker->date(),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'separated', 'widowed']),
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'qualification' => $this->faker->randomLetter,
            'is_directorship_president' => $this->faker->boolean,
            'is_management_member' => $this->faker->boolean,
            'is_customer_service' => $this->faker->boolean,
        ];
    }
}
