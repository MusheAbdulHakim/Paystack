<?php


declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

use MusheAbdulHakim\Paystack\Api\Plan;
use MusheAbdulHakim\Paystack\Api\Product;
use MusheAbdulHakim\Paystack\Api\ApplePay;
use MusheAbdulHakim\Paystack\Api\Customer;
use MusheAbdulHakim\Paystack\Api\Terminal;
use MusheAbdulHakim\Paystack\Api\Transfer;
use MusheAbdulHakim\Paystack\Api\Settlement;
use MusheAbdulHakim\Paystack\Api\SubAccount;
use MusheAbdulHakim\Paystack\Api\PaymentPage;
use MusheAbdulHakim\Paystack\Api\Transaction;
use MusheAbdulHakim\Paystack\Api\Subscription;
use MusheAbdulHakim\Paystack\Api\PaymentRequest;
use MusheAbdulHakim\Paystack\Api\VirtualAccount;
use MusheAbdulHakim\Paystack\Api\TransactionSplit;
use MusheAbdulHakim\Paystack\Api\TransferControl;
use MusheAbdulHakim\Paystack\Api\TransferRecipient;
use MusheAbdulHakim\Paystack\Contracts\TransporterContract;
use MusheAbdulHakim\Paystack\Contracts\PaystackClientInterface;

final readonly class Client implements PaystackClientInterface
{
    /**
     * Creates a Client instance with the given API token.
     */
    public function __construct(private TransporterContract $transporter)
    {
        // ..
    }

    public function transaction(): Transaction
    {
        return new Transaction($this->transporter);
    }

    public function transactionSplit(): TransactionSplit
    {
        return new TransactionSplit($this->transporter);
    }

    public function terminal(): Terminal
    {
        return new Terminal($this->transporter);
    }

    public function customer(): Customer
    {
        return new Customer($this->transporter);
    }

    public function virtualAccount(): VirtualAccount
    {
        return new VirtualAccount($this->transporter);
    }


    public function applePay(): ApplePay
    {
        return new ApplePay($this->transporter);
    }

    public function subAccount(): SubAccount
    {
        return new SubAccount($this->transporter);
    }

    public function plan(): Plan
    {
        return new Plan($this->transporter);
    }

    public function subscription(): Subscription
    {
        return new Subscription($this->transporter);
    }

    public function product(): Product
    {
        return new Product($this->transporter);
    }

    public function paymentPage(): PaymentPage
    {
        return new PaymentPage($this->transporter);
    }

    public function paymentRequest(): PaymentRequest
    {
        return new PaymentRequest($this->transporter);
    }

    public function settlement(): Settlement
    {
        return new Settlement($this->transporter);
    }


    public function transferRecipient(): TransferRecipient
    {
        return new TransferRecipient($this->transporter);
    }

    public function transfer(): Transfer
    {
        return new Transfer($this->transporter);
    }

    public function transferControl(): TransferControl
    {
        return new TransferControl($this->transporter);
    }

}
