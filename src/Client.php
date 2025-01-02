<?php


declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

use MusheAbdulHakim\Paystack\Api\ApplePay;
use MusheAbdulHakim\Paystack\Api\Customer;
use MusheAbdulHakim\Paystack\Api\Terminal;
use MusheAbdulHakim\Paystack\Api\Transaction;
use MusheAbdulHakim\Paystack\Api\TransactionSplit;
use MusheAbdulHakim\Paystack\Api\VirtualAccount;
use MusheAbdulHakim\Paystack\Contracts\PaystackClientInterface;
use MusheAbdulHakim\Paystack\Contracts\TransporterContract;

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

}
