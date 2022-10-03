<?php

namespace App\Modules\HR\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\VacationType;



class ResignationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\Resignation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory()->create()->id,
            'resignation_date'=>$this->faker->date(),
            'notes'=>$this->faker->text(50),
        ];
       
    }
}
