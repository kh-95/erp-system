<?php

namespace App\Modules\RiskManagement\Database\Seeders;

use App\Modules\RiskManagement\Entities\BankVendor;
use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Entities\Bank;
use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Entities\Transaction;
use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Entities\VendorClass;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RiskManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Vendor::factory(100)->create();
        Notification::factory(100)->create();
        Transaction::factory(100)->create();
        Bank::factory(5)->create();
        VendorClass::factory(5)->create();
        NotificationVendor::factory(100)->create();
        BankVendor::factory(5)->create();
    }
}
