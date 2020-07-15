<?php

namespace Webikevn\AuthenticateShopping;

use Illuminate\Support\ServiceProvider;

class AuthenticateShoppingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/shopping_authenticate.php' => config_path('shopping_authenticate.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/shopping_authenticate.php', 'shopping_authenticate'
        );
    }
}