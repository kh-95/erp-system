<?php

namespace App\Modules\HR\Database\factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Employee;





class EmployeeJobInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\HR\Entities\EmployeeJobInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'job_id'=> Job::factory()->create()->id,
            'employee_id'=> Employee::factory()->create()->id  ,
            'employee_number'=>rand(111111, 999999),
            'contract_type'=> $this->faker->randomLetter(10),
            'receiving_work_date'=> $this->faker->date('Y-m-d'),
            'contract_period'=> 2,
            'salary'=> $this->faker->numerify('#####'),
            'other_allowances'=> 0,
            'salary_percentage'=> null,
        ];
    }
}





