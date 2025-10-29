<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    $target = public_path('storage');
    $link = storage_path('app/public');

    if (!file_exists($target)) {
        // Fallback if symlink is not supported
        File::copyDirectory($link, $target);
    }
}

}
