<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

class Paystack
{
    /**
     * Initialize the client factory.
     * This gives you control over the client. you will be able to set headers, baseurl,
     * and httpclient.
     */
    public static function init(string $secretKey): Factory
    {
        return self::factory()
            ->withSecretKey($secretKey);
    }

    public static function client(string $secretKey, string $baseUri = ''): Client
    {
        return self::factory()
            ->withBaseUri($baseUri)
            ->withSecretKey($secretKey)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom Client
     */
    public static function factory(): Factory
    {
        return new Factory();
    }
}
