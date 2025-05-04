<?php

namespace Database\Seeders;

use App\Models\Notification;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 3; $i++) {
            $notification = Notification::create([
                'url' => $faker->url,
                'mobile_link' => $faker->url,
                'app_users' => 1,
                'website_users' => 1,
                'admins' => 1,
                'managers' => 1,
                'members' => 1,
                'both' => 1,
                'system_notification' => 1,
                'sms' => 1,
                'email' => 1,
            ]);
            $notification->translations()->create([
                'locale' => 'en',
                'title' => 'title ' . $i,
                'body' => 'body ' . $i,
            ]);
            $notification->translations()->create([
                'locale' => 'ar',
                'title' => 'title1 ' . $i,
                'body' => 'body1 ' . $i,
            ]);
        }
    }
}
