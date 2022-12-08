<?php

namespace Rklab\Crud\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/crud'),
        ]);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/crud'),
        ], 'public');

        $this->loadRoutesFrom(__DIR__.'/../routes/crud.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'crud');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Paginator::useBootstrap();
    }
}
