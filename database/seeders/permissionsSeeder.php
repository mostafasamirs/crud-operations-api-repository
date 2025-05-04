<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Admin' => ['admins.index', 'admins.create', 'admins.edit', 'admins.destroy', 'admins.restore', 'admins.forceDelete', 'admins.trashed'],
            'City' => ['cities.index', 'cities.create', 'cities.edit', 'cities.destroy', 'cities.restore', 'cities.forceDelete', 'cities.trashed'],
            'Country' => ['countries.index', 'countries.create', 'countries.edit', 'countries.destroy', 'countries.restore', 'countries.forceDelete', 'countries.trashed'],
            'Blog' => ['blogs.index', 'blogs.create', 'blogs.edit', 'blogs.destroy', 'blogs.restore', 'blogs.forceDelete', 'blogs.trashed'],
            'Contact Us' => ['contact-us.index', 'contact-us.create', 'contact-us.edit', 'contact-us.destroy', 'contact-us.restore', 'contact-us.forceDelete', 'contact-us.trashed'],
            'FAQ' => ['faqs.index', 'faqs.create', 'faqs.edit', 'faqs.destroy'],
            'roles'=>['roles.index','roles.create','roles.edit','roles.destroy'],
            'History' => ['histories.index'],
            'Home' => ['home.index'],
            'News Article' => ['news.index', 'news.create', 'news.edit', 'news.destroy', 'news.restore', 'news.forceDelete', 'news.trashed'],
            'Slider' => ['sliders.index', 'sliders.create', 'sliders.edit', 'sliders.destroy', 'sliders.restore', 'sliders.forceDelete', 'sliders.trashed'],
            'Notification' => ['notifications.index', 'notifications.create', 'notifications.edit', 'notifications.destroy'],
            'Setting' => ['setting.index', 'setting.edit'],
            'Sub Page' => ['sub_pages.index', 'sub_pages.create', 'sub_pages.edit', 'sub_pages.destroy', 'sub_pages.restore', 'sub_pages.forceDelete', 'sub_pages.trashed'],
            'Translation' => ['translations.index', 'translations.edit'],
        ];

        foreach ($permissions as $category => $perms) {
            foreach ($perms as $permission) {
                Permission::findOrCreate($permission, 'admin');
            }
        }
    }
}
