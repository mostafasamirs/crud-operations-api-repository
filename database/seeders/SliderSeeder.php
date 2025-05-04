<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            $slider = Slider::create([
                'website_link' => 'https://laravel.com',
                'mobile_link' => '/mobile/intro',
                'is_active' => 1,
                'slug' => Str::slug('slider  slug ' . $i),
            ]);
            $slider->translations()->create([
                'locale' => 'en',
                'title' => 'Building APIs with Laravel' . $i,
                'description' => 'Laravel is a web application framework with expressive, elegant syntax.' . $i,
                'short_description' => 'Master advanced Laravel.' . $i,
                'slider_id' => $slider->id,
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description ' . $i,
                'meta_keywords' => 'Meta Keywords ' . $i,
                'meta_tags' => 'Meta tags ,Meta tags2 ',
            ]);
            $slider->translations()->create([
                'locale' => 'ar',
                'title' => 'Building APIs with Laravel2 ar' . $i,
                'description' => 'Laravel is a web application framework with expressive, elegant syntax.2 ar' . $i,
                'short_description' => 'Master advanced Laravel2.ar' . $i,
                'slider_id' => $slider->id,
                'meta_title' => 'Meta Title ' . $i,
                'meta_description' => 'Meta Description ar ' . $i,
                'meta_keywords' => 'Meta Keywords ar ' . $i,
                'meta_tags' => 'Meta tags ar' . $i,
            ]);

        }
    }
}
