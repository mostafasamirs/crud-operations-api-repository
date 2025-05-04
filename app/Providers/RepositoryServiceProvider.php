<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $repositories = [
            \App\Repositories\Interfaces\BlogRepositoryInterface::class => \App\Repositories\BlogRepository::class,
            \App\Repositories\Interfaces\NewsRepositoryInterface::class => \App\Repositories\NewsRepository::class,
            \App\Repositories\Interfaces\AdminRepositoryInterface::class => \App\Repositories\AdminRepository::class,
            \App\Repositories\Interfaces\CityRepositoryInterface::class => \App\Repositories\CityRepository::class,
            \App\Repositories\Interfaces\CountryRepositoryInterface::class => \App\Repositories\CountryRepository::class,
            \App\Repositories\Interfaces\FAQRepositoryInterface::class => \App\Repositories\FAQRepository::class,
            \App\Repositories\Interfaces\ContactUsRepositoryInterface::class => \App\Repositories\ContactUsRepository::class,
            \App\Repositories\Interfaces\NotificationRepositoryInterface::class => \App\Repositories\NotificationRepository::class,
            \App\Repositories\Interfaces\RoleRepositoryInterface::class => \App\Repositories\RoleRepository::class,
            \App\Repositories\Interfaces\SubPageRepositoryInterface::class => \App\Repositories\SubPageRepository::class,
            \App\Repositories\Interfaces\SliderRepositoryInterface::class => \App\Repositories\SliderRepository::class,
            \App\Repositories\Interfaces\SettingRepositoryInterface::class => \App\Repositories\SettingRepository::class,
        ];

        foreach ($repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
