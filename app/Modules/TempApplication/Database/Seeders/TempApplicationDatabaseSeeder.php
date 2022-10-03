<?php

namespace App\Modules\TempApplication\Database\Seeders;

use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TempApplicationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Customer::factory(5)->create();


        // $this->call("OthersTableSeeder");
    }
}
