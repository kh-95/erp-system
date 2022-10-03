<?php

namespace App\Modules\Secretariat\Database\factories;

use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Entities\MeetingRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Secretariat\Entities\Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'employee_id' => Employee::factory()->create()->id,
            'meeting_date' => $this->faker->dateTime->format('d-m-Y H:i'),
            'meeting_room_id' => MeetingRoom::factory()->create()->id,
            'type' => 'type',
            'meeting_duration' => rand(1,180),
            'note' => $this->faker->sentence,
        ];
    }
}

