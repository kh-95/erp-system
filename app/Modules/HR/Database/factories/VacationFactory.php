<?php

namespace App\Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\VacationType;



class VacationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Vacation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vacation_employee_id' => Employee::factory()->create()->id,
            'vacation_type_id' => VacationType::factory()->create()->id,
            'vacation_from_date'=>$this->faker->date(),
            'vacation_to_date'=>$this->faker->date(),
            'number_days'=>$this->faker->numerify('###'),
            'alter_employee_id' => Employee::factory()->create()->id,
            'notes'=>$this->faker->text(50),
        ];
       
    }
}
