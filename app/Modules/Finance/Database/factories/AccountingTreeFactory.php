<?php

namespace App\Modules\Finance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class AccountingTreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Finance\Entities\AccountingTree::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'revise_no' => $this->faker->numerify('###'),
            'parent_id'=>'0',
            'payment_check'=>'0',
            'collect_check'=>'0',
            'account_code'=>$this->faker->text(5),
            'account_name'=>$this->faker->text(10),
            'notes'=>$this->faker->text(50),
        ];
       
    }
}
