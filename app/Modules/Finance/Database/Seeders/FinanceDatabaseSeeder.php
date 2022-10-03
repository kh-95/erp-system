<?php

namespace App\Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Finance\Entities\AccountingTree;
use App\Modules\Finance\Entities\AssetCategory;
use App\Modules\Finance\Entities\ConstraintType;
use App\Modules\Finance\Entities\ExpenseType;
use App\Modules\Finance\Entities\ReceiptType;
use App\Modules\Finance\Entities\NotificationName;



class FinanceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        AccountingTree::factory(5)->create();
        AssetCategory::factory(5)->create();
        ConstraintType::factory(5)->create();
        ExpenseType::factory(5)->create();
        ReceiptType::factory(5)->create();
        NotificationName::factory(5)->create();
    }
}
