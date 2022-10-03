<?php

namespace Database\Seeders;

use App\Models\Country\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = include database_path('init_data/country.php');
        foreach ($countries as $country) {
            Country::create([
                "phone_code" => $country["phone"],
                'ar' => [
                    'name' => $country['name_ar'],
                ]
            ]);
        }
    }
}
