<?php

namespace App\Providers;

use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/query.log'),
            ])->debug($query->sql, $query->bindings);
        });
    }
}
