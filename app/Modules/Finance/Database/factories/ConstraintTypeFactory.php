<?php

namespace App\Modules\Finance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Finance\Entities\ConstraintType;


class ConstraintTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Finance\Entities\ConstraintType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->text(10),
            'notes'=>$this->faker->text(50),
        ];
       
    }
}
