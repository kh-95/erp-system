<?php

namespace App\Modules\CustomerService\Database\factories;

use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\CustomerService\Entities\Message;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\CustomerService\Entities\Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'identity_number' => $this->faker->numberBetween(1,1000),
            'phone' => $this->faker->phoneNumber,
            'text' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(Message::TYPES),
            'employee_id' => Employee::factory()->create(),
        ];
    }
}
