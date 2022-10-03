<?php

namespace App\Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attend_time' => '8:00',
            'leave_time' => '17:00',
            'month_Date' => '26',
            'permission_duration' => 90
        ];

    }
}
