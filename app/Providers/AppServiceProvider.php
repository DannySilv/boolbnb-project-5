<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway(
                [
                    'environment' => 'sandbox',
                    'merchantId' => 'jh4yhh2hfcrcgcy4',
                    'publicKey' => 'gcppcb25tys46633',
                    'privateKey' => '81ee52c91b08ef4e69831cd2798cc28f'
                ]
            );
        });
    }
}
