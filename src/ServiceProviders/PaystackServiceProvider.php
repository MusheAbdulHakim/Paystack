<?php

namespace Musheabdulhakim\Paystack\ServiceProviders;

use Musheabdulhakim\Paystack\Paystack;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Musheabdulhakim\Paystack\Facades\PaystackFacade;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Determine if the provider is deferred.
     *
     * @return bool
     */
    public function isDeferred()
    {
        return true;
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../Config/paystack.php' => config_path('paystack.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/paystack.php',
            'paystack'
        );
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Paystack::class
        ];
    }

}
