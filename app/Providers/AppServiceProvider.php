<?php

namespace App\Providers;

use Exception;
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
        try {
            DB::listen(function ($query) {
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/query.log'),
                ])->debug($query->sql, $query->bindings);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), (array) $e);
        }
    }
}
