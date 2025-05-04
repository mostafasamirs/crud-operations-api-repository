<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('coupon:update-status', function () {
    $this->command('queue:work --queue=high,default,medium,low --stop-when-empty')->everyMinute()->withoutOverlapping();
})->purpose('Display an inspiring quote')->everyMinute()->withoutOverlapping();

