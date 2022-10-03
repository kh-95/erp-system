<?php

namespace App\Modules\Collection\Database\factories;

use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;


class InstallmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Collection\Entities\Installment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_from' => $this->faker->date(),
            'date_to' => $this->faker->date(),
            'amount_from'=> $this->faker->numerify('#####'),
            'amount_to'=> $this->faker->numerify('#####'),
            'date_entitlement' => $this->faker->date,
            'status' => $this->faker->randomElement(['waiting_eligibility','worthy','paid','late']),
            'penalty_value_delay'  =>$this->faker->text(10),
            'customer_id' => Customer::factory()->create(),
            'customer_service_id' => Customer::factory()->create(),

        ];
    }
}
