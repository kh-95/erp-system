<?php

namespace App\Modules\Reception\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Management;

class VisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Reception\Entities\Visit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'management_id'=> Management::factory()->create()->id,
            'en' => ['type' => $this->faker->text($maxNbChars = 150),
                     'note' => $this->faker->text($maxNbChars = 500)],
            'ar' => ['type' => $this->faker->text($maxNbChars = 150),
                     'note' => $this->faker->text($maxNbChars = 500)],
            'status' => 'new',
        ];
    }
}

