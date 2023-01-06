<?php
declare(strict_types=1);

use Musheabdulhakim\Paystack\Paystack;
use Musheabdulhakim\Paystack\Tests\TestCase;

class PaystackTest extends TestCase {
    

    public function testPaystack(){
        $paystack = new Paystack();
        $this->assertInstanceOf(Paystack::class, $paystack);
    }


    public function testSetSecretKey(){
        $paystack = new Paystack();
        $this->assertIsBool($paystack->SecretKey('alsjdlkfajlfdalskfladsjflkdsajlfkasdjld'));
    }

    public function testGetSecretkey(){
        $paystack = new Paystack();
        $this->assertIsString($paystack->SecretKey());
    }

   

}