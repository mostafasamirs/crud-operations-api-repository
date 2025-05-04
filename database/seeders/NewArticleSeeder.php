<?php

namespace Database\Seeders;
use App\Models\NewsArticle;
use \Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $news = NewsArticle::create([

                'is_active' => 1,
                'link' => 'https://example.com',
                'slug' => Str::slug('article  slug ' . $i),
            ]);

            $news->translations()->create([
                'locale' => 'en',
                'title' => 'Title ' . $i,
                'description' => 'Description ' . $i,
                'short_description' => 'Short Description ' . $i,
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description ' . $i,
                'meta_keywords' => 'Meta Keywords ' . $i,
                'meta_tags' => 'Meta tags ' . $i,
            ]);

            $news->translations()->create([
                'locale' => 'ar',
                'title' => 'عنوان ' . $i,
                'description' => 'وصف ' . $i,
                'short_description' => 'وصف قصير ' . $i,
                'meta_title' => 'عنوان ميتا ' . $i,
                'meta_description' => 'وصف ميتا ' . $i,
                'meta_keywords' => 'كلمات ميتا ' . $i,
                'meta_tags' => 'تاغات ميتا ' . $i,

            ]);
        }
    }
}
