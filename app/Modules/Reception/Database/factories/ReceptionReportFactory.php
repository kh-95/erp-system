<?php

namespace App\Modules\Reception\Database\factories;

use App\Modules\HR\Entities\Management;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceptionReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Reception\Entities\ReceptionReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->Name,
            'management_id'=> Management::factory()->create()->id  ,
            'description'=> $this->faker->randomLetter(100),
            'status'=>'new' ,
            'date'=>Carbon::now()->format('Y-m-d H:i'),
        ];
    }
}

