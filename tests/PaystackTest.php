<?php

declare(strict_types=1);

use Musheabdulhakim\Paystack\Paystack;
use Musheabdulhakim\Paystack\Tests\TestCase;

class PaystackTest extends TestCase
{
    protected $paystack;

    protected function setUp(): void
    {
        $this->paystack = new Paystack([
            'secret_key' => getenv('SECRET_KEY'),
            'public_key' => getenv('PUBLIC_KEY'),
            'merchant_email' => getenv('MERCHANT_EMAIL'),
            'base_url' => 'https://api.test.paystack.co',
        ], false);
    }

    public function testPaystack()
    {
        $this->assertInstanceOf(Paystack::class, $this->paystack);
    }

    public function testConstructorSetsDefaultValues()
    {
        $this->assertNotEmpty($this->paystack->baseUrl());
        $this->assertNotEmpty($this->paystack->merchantEmail());
        $this->assertNotEmpty($this->paystack->secretKey());
        $this->assertNotEmpty($this->paystack->publicKey());
    }

    public function testConstructorSetsPropertiesCorrectly()
    {
        $options = [
            'secret_key' => getenv('SECRET_KEY'),
            'public_key' => getenv('PUBLIC_KEY'),
            'merchant_email' => getenv('MERCHANT_EMAIL'),
            'base_url' => 'https://api.test.paystack.co'
        ];
        $this->assertEquals($options['base_url'], $this->paystack->baseUrl());
        $this->assertEquals($options['merchant_email'], $this->paystack->merchantEmail());
        $this->assertEquals($options['secret_key'], $this->paystack->secretKey());
        $this->assertEquals($options['public_key'], $this->paystack->publickey());
    }

    public function testConstructorReadsEnvVariables()
    {
        $this->assertEquals('test_secret_key', $this->paystack->secretKey());
        $this->assertEquals('test_public_key', $this->paystack->publickey());
        $this->assertEquals('test@example.com', $this->paystack->merchantEmail());
    }

    public function testConstructorSetsPropertiesInConfigObject()
    {
        $config = $this->paystack->getConfig();
        $this->assertEquals($this->paystack->baseUrl(), $config->get('base_url'));
        $this->assertEquals($this->paystack->merchantEmail(), $config->get('merchant_email'));
        $this->assertEquals($this->paystack->secretKey(), $config->get('secret_key'));
        $this->assertEquals($this->paystack->publickey(), $config->get('public_key'));
    }


    public function testSetAndGetBaseUrl()
    {
        $this->assertTrue($this->paystack->baseUrl('https://api.test.paystack.co'));
        $this->assertEquals('https://api.test.paystack.co', $this->paystack->baseUrl());

        $this->assertEquals($this->paystack->baseUrl(), $this->paystack->baseURL());
    }

    public function testsecretKey()
    {
        // Test setting a valid secret key
        $this->assertTrue($this->paystack->secretKey('test_secret_key'));
        $this->assertEquals('test_secret_key', $this->paystack->secretKey());

        $this->assertEquals($this->paystack->secretKey(), $this->paystack->secretKey());
    }

    public function testSetAndGetMerchant()
    {
        // Test setting a valid merchant email
        $this->assertTrue($this->paystack->merchantEmail('test@example.com'));
        $this->assertEquals('test@example.com', $this->paystack->merchantEmail());

        $this->assertEquals($this->paystack->merchantEmail(), $this->paystack->merchantEmail());
    }

    public function testSetAndGetPublicKey()
    {
        // Test setting a valid public key
        $this->assertTrue($this->paystack->publicKey('test_public_key'));
        $this->assertEquals('test_public_key', $this->paystack->publicKey());

        $this->assertEquals($this->paystack->publickey(), $this->paystack->publicKey());
    }

    public function testAndVerifyPublicKEY(){
        $this->assertEquals($this->paystack->publickey(),$_ENV['PUBLIC_KEY']);
    }

}
