<?php

namespace App\Modules\Legal\Database\factories;

use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalOpinionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Legal\Entities\LegalOpinionFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

        public function definition()
        {
            return [
                'text' => $this->faker->text(10),
                'added_by_id' => Employee::factory()->create()->id

            ];

        }

}

