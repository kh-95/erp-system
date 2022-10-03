<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\CustomerService\Database\Seeders\CustomerServiceDatabaseSeeder;
use App\Modules\Governance\Database\Seeders\GovernanceDatabaseSeeder;
use App\Modules\HR\Database\Seeders\HRDatabaseSeeder;
use App\Modules\Legal\Database\Seeders\LegalDatabaseSeeder;
use App\Modules\Reception\Database\Seeders\ReceptionDatabaseSeeder;
use App\Modules\RiskManagement\Database\Seeders\RiskManagementDatabaseSeeder;
use App\Modules\Secretariat\Database\Seeders\SecretariatDatabaseSeeder;
use App\Modules\User\Database\Seeders\UserDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HRDatabaseSeeder::class,
            UserDatabaseSeeder::class,
            SecretariatDatabaseSeeder::class,
            CustomerServiceDatabaseSeeder::class,
            GovernanceDatabaseSeeder::class,
            LegalDatabaseSeeder::class,
            ReceptionDatabaseSeeder::class,
            RiskManagementDatabaseSeeder::class,
            CountrySeeder::class
        ]);
        // Artisan::call("module:seed HR");
        // Artisan::call("module:seed User");
        // Artisan::call("module:seed Secretariat");
    }
}
