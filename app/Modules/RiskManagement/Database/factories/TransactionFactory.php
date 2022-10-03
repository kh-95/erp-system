<?php

namespace App\Modules\RiskManagement\Database\factories;

use App\Modules\RiskManagement\Entities\Transaction;
use App\Modules\RiskManagement\Entities\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'transaction_number' => $this->faker->randomNumber(8, true),
            'amount' => $this->faker->randomNumber(4, false),
            'vendor_id' => Vendor::factory()->create()->id,
            'payment_type' => $this->faker->randomElement(Transaction::TYPES),
            'payment_status' => $this->faker->randomElement(Transaction::STATUS),
            'payment_type_ar' => $this->faker->randomElement(Transaction::AR_TYPES),
        ];
    }
}
