<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            SliderSeeder::class,
            NotificationSeeder::class,
            NewArticleSeeder::class,
            BlogSeeder::class,
            SubPageSeeder::class,
            CountrySeeder::class,
            CitiesSeeder::class,
            FAQSeeder::class,
            ContactUsSeeder::class,
            AdminSeeder::class,
            SuperAdminRoleSeeder::class,
            permissionsSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
