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
            __DIR__ . '/assets/js/main.js' => resource_path('js/session.js'),
        ]);

        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/session-out'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/config/expired-session.php' => config_path('expired-session.php'),
        ]);

        $this->publishes([
            __DIR__ . '/Http/Middleware/StartSession.php' => app_path('Http/Middleware/StartSession.php'),
        ]);

        $this->publishes([
            __DIR__ . '/Providers/SessionServiceProvider.php' => app_path('Providers/SessionServiceProvider.php'),
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
