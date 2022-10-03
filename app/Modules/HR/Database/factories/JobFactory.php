<?php

namespace App\Modules\HR\Database\factories;

use App\Modules\HR\Entities\Management;
use Illuminate\Database\Eloquent\Factories\Factory;


class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar' => ['name' => $this->faker->Name, 'description'=> $this->faker->randomLetter(100),],
            'management_id'  => Management::factory()->create()->id  ,
        ];
    }
}

