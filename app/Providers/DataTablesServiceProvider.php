<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\DataTables;
use App\Helpers\DataTablesHelper;

class DataTablesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('datatables', function ($app) {
            return new DataTablesHelper($app['request']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
