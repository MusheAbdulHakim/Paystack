<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Facades;

use Illuminate\Support\Facades\Facade;
use Musheabdulhakim\Paystack\Paystack as PaystackService;

class Paystack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PaystackService::class;
    }
}
