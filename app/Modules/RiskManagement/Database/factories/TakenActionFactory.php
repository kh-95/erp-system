<?php

namespace App\Modules\RiskManagement\Database\factories;

use App\Modules\RiskManagement\Entities\NotificationVendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TakenActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\TakenAction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'taken_action' => $this->faker->randomElement(NotificationVendor::TAKEN_ACTIONS),
            'reasons' => $this->faker->paragraph,
            'notification_vendor_id' => NotificationVendor::factory()->create()
        ];
    }
}

