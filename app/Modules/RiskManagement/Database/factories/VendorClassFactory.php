<?php

namespace App\Modules\RiskManagement\Database\factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\VendorClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar' => ['name' => $this->faker->name]
        ];
    }
}

