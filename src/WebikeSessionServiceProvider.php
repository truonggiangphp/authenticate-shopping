<?php

namespace Webikevn\AuthenticateShopping;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Session;
use Webikevn\AuthenticateShopping\Models\TblMpSession;

class WebikeSessionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function register()
    {
        Session::extend('webike', function ($app) {
            // Return implementation of SessionHandlerInterface...
            $connection = $this->app->make('db')->connection('wgs');
            return new WebikeSessionHandler(
                $connection,
                with(new TblMpSession)->getTable(),
                config('shopping_authenticate.session_expiry'),
                $this->app,
            );
        });
    }
}
