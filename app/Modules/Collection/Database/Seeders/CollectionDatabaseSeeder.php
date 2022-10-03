<?php

namespace App\Modules\Collection\Database\Seeders;

use App\Modules\Collection\Entities\Operation;
use App\Modules\Collection\Entities\Installment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CollectionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Operation::factory(5)->create();
        Installment::factory(100)->create();
        // $this->call("OthersTableSeeder");
    }
}
