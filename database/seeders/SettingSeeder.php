<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::setMany([
            'name' => 'test',
            'description' => 'Storefront',
            'footer' => 'footer',
            'address' => 'cairo',
            'email' => 'test.t.com',
            'phone_number' => '0502155888',
            'mobile_number' => '123456789',
            'whatsapp' => '123456789',
            'fax_number' => '0123456789',
            'iphone_url' => 'https://apps.apple.com/us/app/t.test/id123456789',
            'android_url' => 'https://play.google.com/store/apps/details?id=com.t.test',
            'facebook_url' => 'https://www.facebook.com/t.test',
            'instagram_url' => 'https://www.instagram.com/t.test',
            'tiktok_url' => 'https://www.tiktok.com/@t.test',
            'snapchat_url' => 'https://www.snapchat.com/add/t.test',
            'twitter_url' => 'https://www.twitter.com/t.test',
//            'logo' => 'https://example.com/default-logo.png',
//            'favicon' => 'https://example.com/default-favicon.ico',
        ]);
    }
}
