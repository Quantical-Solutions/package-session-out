<?php

namespace App\Providers;

use Illuminate\Session\SessionServiceProvider as BaseSessionServiceProvider;

class SessionServiceProvider extends BaseSessionServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionManager();

        $this->registerSessionDriver();

        $this->app->singleton('App\Http\Middleware\StartSession');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
