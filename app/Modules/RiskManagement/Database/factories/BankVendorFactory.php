<?php

namespace App\Modules\RiskManagement\Database\factories;

use App\Modules\RiskManagement\Entities\Bank;
use App\Modules\RiskManagement\Entities\BankVendor;
use App\Modules\RiskManagement\Entities\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankVendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\BankVendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bank_id' => Bank::factory()->create(),
            'vendor_id' => Vendor::factory()->create(),
            'iban' => $this->faker->iban('SA', '', '16'),
            'status' => $this->faker->randomElement(BankVendor::STATUS),
        ];
    }
}

