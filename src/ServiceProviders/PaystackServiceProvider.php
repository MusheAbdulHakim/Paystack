<?php

namespace Musheabdulhakim\Paystack\ServiceProviders;

use Musheabdulhakim\Paystack\Paystack;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Musheabdulhakim\Paystack\Facades\PaystackFacade;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * The paths that should be published.
     *
     * @var array
     */
    public static $publishes = [
        __DIR__ . '/Config/paystack.php' => config_path('paystack.php'),
    ];

    /**
     * Determine if the provider is deferred.
     *
     * @return bool
     */
    public function isDeferred()
    {
        return false;
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
