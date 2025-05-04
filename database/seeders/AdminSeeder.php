<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $admin = Admin::create([
                'is_active' => 1,
                'mobile' => "123456789.$i",
                'nationality_id'=> 1,
                'country_id'=>2,
                'email' => "test.$i@t.com",
                'password'=>Hash::make('123456789'),
                'identity'=>"123456.$i"

            ]);
            $admin->translations()->create([
                'locale' => 'en',
                'first_name' =>"test . $i",
                'second_name' => "test . $i",
                'third_name'=>"test.$i",
                'last_name' => "test.$i"
            ]);

            $admin->translations()->create([
                'locale' => 'ar',
                'first_name' =>"كبريت . $i",
                'second_name' => "كبريت . $i",
                'third_name'=>"كبريت.$i",
                'last_name' => "كبريت.$i"
            ]);
        }
    }
}
