<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Artisan::command('cache:clear', function () {
// })->purpose('Display an inspiring quote')->hourly();

// Artisan::command('cache:clear')->everyMinute();