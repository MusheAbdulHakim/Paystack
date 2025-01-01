<?php


declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

use MusheAbdulHakim\Paystack\Contracts\PaystackClientInterface;
use MusheAbdulHakim\Paystack\Contracts\TransporterContract;

final readonly class Client implements PaystackClientInterface
{
    /**
     * Creates a Client instance with the given API token.
     */
    public function __construct()
    {
        // ..
    }


}
