<?php

namespace App\Modules\Reception\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Reception\Entities\Visit;

class VisitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Reception\Entities\Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->text($maxNbChars = 150),
            "identity_number" => $this->faker->numerify('########'),
            'visit_id' => Visit::factory()->create()->id,
        ];
    }
}

