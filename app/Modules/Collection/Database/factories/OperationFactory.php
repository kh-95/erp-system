<?php

namespace App\Modules\Collection\Database\Factories;

use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Collection\Entities\Operation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            return [
                'operation_number'=>rand(111111, 999999),
                'amount'=> $this->faker->numerify('#####'),
                'customer_id'=> Customer::factory()->create()->id  ,
                'installment_id'=> Customer::factory()->create()->id  ,
                'customer_service_id'=> Customer::factory()->create()->id ,
                'status' => $this->faker->randomElement(['completed', 'not_completed', 'failed']),
                'date' => $this->faker->date(),
            ];

    }
}
