<?php

namespace App\Modules\HR\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;

class DeductBounceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\DeductBounce::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'management_id'  => Management::factory()->create()->id  ,
            'employee_id'=> Employee::factory()->create()->id  ,
            'action_type' => $this->faker->randomElement(['amount', 'duration']),
            'amount'      =>$this->faker->amount,
            'duration'      =>$this->faker->duration,
            'notes'    => $this->faker->randomLetter(100),
            'status'   => $this->faker->randomElement(['Awaiting_approval', 'approval','rejected']),
        ];
    }
}

