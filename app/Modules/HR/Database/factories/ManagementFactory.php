<?php

namespace App\Modules\HR\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManagementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Management::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ar'      => ['name' => $this->faker->Name, 'description'=> $this->faker->randomLetter(100),],
            'parent_id'  => null  ,
        ];
    }
}

