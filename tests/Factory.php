<?php

use MusheAbdulHakim\Paystack\Client;
use MusheAbdulHakim\Paystack\Factory;
use Psr\Http\Client\ClientInterface;

it('can create a client with a secret key', function () {
    $client = (new Factory())->withSecretKey('sk_test_123')->make();

    expect($client)->toBeInstanceOf(Client::class);
});

it('can create a client with a public key', function () {
    $client = (new Factory())->withPublicKey('pk_test_123')->make();

    expect($client)->toBeInstanceOf(Client::class);
});

it('can create a client with a base URI', function () {
    $client = (new Factory())->withBaseUri('https://example.com')->make();

    expect($client)->toBeInstanceOf(Client::class);
});

it('can create a client with a custom HTTP client', function () {
    $httpClient = Mockery::mock(ClientInterface::class);

    $client = (new Factory())->withHttpClient($httpClient)->make();

    expect($client)->toBeInstanceOf(Client::class);
});

it('can create a client with a custom HTTP header', function () {
    $client = (new Factory())->withHttpHeader('X-Custom', 'value')->make();

    expect($client)->toBeInstanceOf(Client::class);
});