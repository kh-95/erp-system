<?php

namespace App\Modules\CustomerService\Database\Seeders;

use App\Modules\CustomerService\Entities\Call;
use App\Modules\CustomerService\Entities\Message;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomerServiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Call::factory(100)->create();
        Message::factory(100)->create();
    }
}
