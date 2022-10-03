<?php

namespace App\Modules\RiskManagement\Database\factories;

use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Entities\VendorClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->name,
            'identity_number' => $this->faker->randomNumber(8, true),
            'class_id' => VendorClass::factory()->create(),
            'commercial_record' => $this->faker->randomNumber(5, true),
            'tax_number' => $this->faker->randomNumber(5, true),
            'rasid_jack' => $this->faker->randomNumber(2, true),
            'rasid_maak' => $this->faker->randomNumber(2, true),
            'rasid_pay' => $this->faker->randomNumber(2, true),
            'total_pays' => $this->faker->randomNumber(3, true),
            'daily_expected_sales_amount' => $this->faker->randomNumber(4, true),
            'daily_expected_activity_amount' => $this->faker->randomNumber(3, true),
            'maak_service_provider' => $this->faker->randomElement([true, false]),
            'pay_service_provider' => $this->faker->randomElement([true, false]),
            'is_active' => $this->faker->randomElement([true, false]),
            'type' => $this->faker->randomElement(Vendor::TYPES),
            'subscription' => $this->faker->randomElement(Vendor::SUBSCRIPTIONS),

        ];
    }
}
