<?php

namespace Webikevn\AuthenticateShopping;

use Illuminate\Session\Console\SessionTableCommand;
use Illuminate\Support\ServiceProvider;
use Webikevn\AuthenticateShopping\Console\CreateMpSessionCommand;

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

        $this->loadMigrationsFrom(__DIR__ . '/Database');

        $this->app->bind(CreateMpSessionCommand::class, function ($app) {
            return new CreateMpSessionCommand($app['files'], $app['composer']);
        });

        $this->registerCommands();
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


    /**
     * @return void
     */
    private function registerCommands()
    {
        $this->commands([
            CreateMpSessionCommand::class,
        ]);
    }
}