<?php

namespace App\Modules\CustomerService\Database\factories;

use App\Modules\CustomerService\Entities\Call;
use App\Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class CallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\CustomerService\Entities\Call::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory()->create(),
            'duration' => $this->faker->numberBetween(1, 100),
            'client_name' => $this->faker->name,
            'client_identity_number' => $this->faker->randomNumber(),
            'client_phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(Call::STATUSES),
            'media' => 'https://www.soundsnap.com/ten_year_old_boys_cartoon_voice_says_sneeze_hard_fake_blastwavefx_21291',
        ];
    }
}
