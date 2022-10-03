<?php

namespace App\Modules\Finance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Finance\Entities\AccountingTree;


class AssetCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Finance\Entities\AssetCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'revise_no' => $this->faker->numerify('###'),
            'account_tree_id'=> AccountingTree::factory()->create()->id,
            'destroy_check'=>'0',
            'destroy_ratio'=>$this->faker->numerify('###'),
            'name'=>$this->faker->text(10),
            'notes'=>$this->faker->text(50),
        ];
       
    }
}
