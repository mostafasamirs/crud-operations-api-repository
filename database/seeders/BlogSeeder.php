<?php

namespace Database\Seeders;
use App\Models\Blog;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $blog = Blog::create([
                'is_active' => 1,
                'link' => 'https://example.com',
                'slug' => Str::slug('article  slug ' . $i),
            ]);
            $blog->translations()->create([
                'locale' => 'en',
                'title' => 'Title ' . $i,
                'description' => 'Description ' . $i,
                'short_description' => 'Short Description ' . $i,
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description ' . $i,
                'meta_keywords' => 'Meta Keywords ' . $i,
                'meta_tags' => 'Meta tags ' . $i,
            ]);

            $blog->translations()->create([
                'locale' => 'ar',
                'title' => 'عنوان ' . $i,
                'description' => 'وصف ' . $i,
                'short_description' => 'وصف قصير ' . $i,
                'meta_title' => 'عنوان الميتا ' . $i,
                'meta_description' => 'وصف الميتا ' . $i,
                'meta_keywords' => 'كلمات الميتا ' . $i,
                'meta_tags' => 'العلامات الميتا ' . $i,
            ]);
        }
    }
}
