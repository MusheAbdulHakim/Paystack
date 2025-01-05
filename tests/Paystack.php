<?php

use GuzzleHttp\Client as GuzzleHttpClient;
use MusheAbdulHakim\Paystack\Client;
use MusheAbdulHakim\Paystack\Factory;
use MusheAbdulHakim\Paystack\Paystack;

it('may create client', function(){
   $paystack = Paystack::client('key');
   expect($paystack)->toBeInstanceOf(Client::class); 
});

it('may create factory', function(){
   $paystack = Paystack::factory();
   expect($paystack)->toBeInstanceOf(Factory::class); 
});

it('may initialize factory', function(){
   $paystack = Paystack::init('secret_key');
   expect($paystack)->toBeInstanceOf(Factory::class); 
});

it('may create client via factory', function(){
   $paystack = Paystack::factory()->withSecretKey('foo')->make();
   expect($paystack)->toBeInstanceOf(Client::class); 
});

it('may create client via init method', function(){
   $paystack = Paystack::init('secret_key')->make();
   expect($paystack)->toBeInstanceOf(Client::class); 
});


it('may set custom http client', function(){
   $paystack = Paystack::init('foot')
               ->withHttpClient(new GuzzleHttpClient)
               ->make();
   expect($paystack)->toBeInstanceOf(Client::class);
});

it('sets api url', function(){
   $paystack = Paystack::client('foo','https://api.paystack.co');
   expect($paystack)->toBeInstanceOf(Client::class); 
});

it('set custom headers', function(){
   $paystack = Paystack::init('foo')
      ->withHttpHeader('custom-Header','foo')
      ->make();
   expect($paystack)->toBeInstanceOf(Client::class);
});

it('set custom query parameters',function(){
   $paystack = Paystack::init('foo')
      ->withQueryParam('param1', 'value')
      ->make();
   expect($paystack)->toBeInstanceOf(Client::class);
});