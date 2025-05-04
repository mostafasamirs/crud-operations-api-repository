<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $country = Country::create([
                'code' => rand(1,10000),
                'is_active' => true,
                'is_default' => false
            ]);
            $country->translations()->create([
                'locale' => 'en',
                'name' => 'Country ' . $i,
                'default_currency' => 'USD'.$i,
                'nationality' => 'America'.$i
            ]);
            $country->translations()->create([
                'locale' => 'ar',
                'name' => 'دولة ' . $i,
                'default_currency' => 'eg'.$i,
                'nationality' => 'مصر'.$i
            ]);

        }
    }
}
