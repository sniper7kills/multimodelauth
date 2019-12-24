<?php

namespace Sniper7Kills\MultiModelAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MultiModelAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/MultiModelAuth.php', 'MultiModelAuth'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('multi-model', function ($app, array $config) {
            return new UserProvider($app['hash'], $config['models']);
        });

        $this->publishes([
            __DIR__.'/../config/MultiModelAuth.php' => config_path('MultiModelAuth.php'),
        ]);
    }
}
