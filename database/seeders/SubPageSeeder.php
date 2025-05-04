<?php

namespace Database\Seeders;
use App\Enums\PagePositionEnum;
use App\Models\SubPage;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 3; $i++) {
            $sub = SubPage::create([
               'is_active' => 1,
                'position' => PagePositionEnum::HEADER,
                'slug' => Str::slug('sub page  slug ' . $i),
            ]);
            $sub->translations()->create([
                'locale' => 'en',
                'name' => 'Sub Page ' . $i,
                'description' => 'Description ' . $i,
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description ' . $i,
                'meta_keywords' => 'Meta Keywords ' . $i,
                'meta_tags' => 'Meta tags ' . $i,
            ]);

            $sub->translations()->create([
                'locale' => 'ar',
                'name' => 'صفحة فرعية ' . $i,
                'description' => 'وصف ' . $i,
                'meta_title' => 'ميتا تايتل ' . $i,
                'meta_description' => 'ميتا ديسكريبشن ' . $i,
                'meta_keywords' => 'ميتا كلمات ' . $i,
                'meta_tags' => 'ميتا تاغ ' . $i,
            ]);
        }
    }
}
