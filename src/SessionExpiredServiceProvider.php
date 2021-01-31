<?php

namespace Quantic\SessionOut;

use Illuminate\Support\ServiceProvider;

class SessionExpiredServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'session-out');
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/session-out'),
        ]);

        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/session-out'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/config/expired-session.php' => config_path('expired-session.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
