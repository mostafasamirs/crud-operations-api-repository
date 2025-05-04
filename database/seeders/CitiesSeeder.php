<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $country = City::create([
                'is_active' => true,
                'country_id' => Country::inRandomOrder()->first()->id,
            ]);
            $country->translations()->create([
                'locale' => 'en',
                'name' => 'city ' . $i,
            ]);
            $country->translations()->create([
                'locale' => 'ar',
                'name' => 'مدينة ' . $i,
            ]);
        }
    }
}
