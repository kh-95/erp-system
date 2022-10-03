<?php

namespace App\Modules\Secretariat\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Employee;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Secretariat\Entities\Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'appointment_date'=>$this->faker->date(),
            'details' => $this->faker->text(), 
            'employee_id'=>Employee::factory()->create()->id,
        ];
       
    }
}
