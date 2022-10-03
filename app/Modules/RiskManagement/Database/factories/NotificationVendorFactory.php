<?php

namespace App\Modules\RiskManagement\Database\factories;

use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Entities\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationVendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\RiskManagement\Entities\NotificationVendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $notify = Notification::factory()->create();
        return [
            'vendor_id' => Vendor::factory()->create(),
            'notification_id' => $notify->id,
            'title' => $notify->title,
            'body' => $notify->body,
            'taken_action' => $this->faker->randomElement(NotificationVendor::TAKEN_ACTIONS)
        ];
    }
}

