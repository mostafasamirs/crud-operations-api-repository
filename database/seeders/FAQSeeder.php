<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $fcq =FAQ::create([
                'is_active' => 1
            ]);
            $fcq->translations()->create([
                'locale' => 'en',
                'answer' => 'Laravel is a web application framework with expressive, elegant syntax.',
                'question' => 'What is Laravel?',

            ]);
            $fcq->translations()->create([
                'locale' => 'ar',
                'question' => 'ما هو لارافيل؟',
                'answer' => 'لارافيل هو إطار عمل لتطبيقات الويب مع بنية بسيطة وأنيقة.',

            ]);
        }


    }
}
