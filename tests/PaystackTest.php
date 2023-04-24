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
        ]);
    }

    public function testPaystack()
    {
        $this->assertInstanceOf(Paystack::class, $this->paystack);
    }

    public function testConstructorSetsDefaultValues()
    {
        $this->assertNotEmpty($this->paystack->BASE_URL);
        $this->assertNotEmpty($this->paystack->MERCHANT_EMAIL);
        $this->assertNotEmpty($this->paystack->SECRET_KEY);
        $this->assertNotEmpty($this->paystack->PUBLIC_KEY);
    }

    public function testConstructorSetsPropertiesCorrectly()
    {
        $options = [
            'secret_key' => getenv('SECRET_KEY'),
            'public_key' => getenv('PUBLIC_KEY'),
            'merchant_email' => getenv('MERCHANT_EMAIL'),
            'base_url' => 'https://api.test.paystack.co'
        ];
        $this->assertEquals($options['base_url'], $this->paystack->BASE_URL);
        $this->assertEquals($options['merchant_email'], $this->paystack->MERCHANT_EMAIL);
        $this->assertEquals($options['secret_key'], $this->paystack->SECRET_KEY);
        $this->assertEquals($options['public_key'], $this->paystack->PUBLIC_KEY);
    }

    public function testConstructorReadsEnvVariables()
    {
        $this->assertEquals('test_secret_key', $this->paystack->SECRET_KEY);
        $this->assertEquals('test_public_key', $this->paystack->PUBLIC_KEY);
        $this->assertEquals('test@example.com', $this->paystack->MERCHANT_EMAIL);
    }

    public function testConstructorSetsPropertiesInConfigObject()
    {
        $config = $this->paystack->getConfig();
        $this->assertEquals($this->paystack->BASE_URL, $config->get('base_url'));
        $this->assertEquals($this->paystack->MERCHANT_EMAIL, $config->get('merchant_email'));
        $this->assertEquals($this->paystack->SECRET_KEY, $config->get('secret_key'));
        $this->assertEquals($this->paystack->PUBLIC_KEY, $config->get('public_key'));
    }


    public function testSetAndGetBaseUrl()
    {
        $this->assertTrue($this->paystack->baseUrl('https://api.test.paystack.co'));
        $this->assertEquals('https://api.test.paystack.co', $this->paystack->baseUrl());

        $this->assertEquals($this->paystack->BASE_URL, $this->paystack->baseURL());
    }

    public function testsecretKey()
    {
        // Test setting a valid secret key
        $this->assertTrue($this->paystack->secretKey('test_secret_key'));
        $this->assertEquals('test_secret_key', $this->paystack->secretKey());

        $this->assertEquals($this->paystack->SECRET_KEY, $this->paystack->secretKey());
    }

    public function testSetAndGetMerchant()
    {
        // Test setting a valid merchant email
        $this->assertTrue($this->paystack->merchant('test@example.com'));
        $this->assertEquals('test@example.com', $this->paystack->merchant());

        $this->assertEquals($this->paystack->MERCHANT_EMAIL, $this->paystack->merchant());
    }

    public function testSetAndGetPublicKey()
    {
        // Test setting a valid public key
        $this->assertTrue($this->paystack->publicKey('test_public_key'));
        $this->assertEquals('test_public_key', $this->paystack->publicKey());

        $this->assertEquals($this->paystack->PUBLIC_KEY, $this->paystack->publicKey());
    }

    public function testAndVerifyPublicKEY(){
        $this->assertEquals($this->paystack->PUBLIC_KEY,$_ENV['PUBLIC_KEY']);
    }

}
