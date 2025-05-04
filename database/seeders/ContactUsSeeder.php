<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $contactUs = ContactUs::create([
                'name' => 'name ' . $i,
                'email' => 'email ' . $i,
                'phone' => 'subject ' . $i,
                'read_at' => now(),
                'message_title' => 'title ' . $i,
                'message_body' => 'body ' . $i,
                'respond_message' => 'respond message ' . $i,
            ]);
        }
    }
}
