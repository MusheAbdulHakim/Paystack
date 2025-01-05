<?php

use MusheAbdulHakim\Paystack\Api\ApplePay;
use MusheAbdulHakim\Paystack\Paystack;
use MusheAbdulHakim\Paystack\Api\Customer;
use MusheAbdulHakim\Paystack\Api\Plan;
use MusheAbdulHakim\Paystack\Api\SubAccount;
use MusheAbdulHakim\Paystack\Api\Subscription;
use MusheAbdulHakim\Paystack\Api\Terminal;
use MusheAbdulHakim\Paystack\Api\Transaction;
use MusheAbdulHakim\Paystack\Api\VirtualAccount;
use MusheAbdulHakim\Paystack\Api\TransactionSplit;

test('has transactions', function () {
    $transaction = Paystack::client('foo')->transaction();
    expect($transaction)->toBeInstanceOf(Transaction::class);
});

test('has transactionSplit', function () {
    $transaction = Paystack::client('foo')->transactionSplit();
    expect($transaction)->toBeInstanceOf(TransactionSplit::class);
});

test('has terminal', function () {
    $transaction = Paystack::client('foo')->terminal();
    expect($transaction)->toBeInstanceOf(Terminal::class);
});

test('has customer', function () {
    $transaction = Paystack::client('foo')->customer();
    expect($transaction)->toBeInstanceOf(Customer::class);
});

test('has virtual account', function () {
    $transaction = Paystack::client('foo')->virtualAccount();
    expect($transaction)->toBeInstanceOf(VirtualAccount::class);
});

test('has apple pay', function () {
    $transaction = Paystack::client('foo')->applePay();
    expect($transaction)->toBeInstanceOf(ApplePay::class);
});


test('has sub account', function () {
    $transaction = Paystack::client('foo')->subAccount();
    expect($transaction)->toBeInstanceOf(SubAccount::class);
});

test('has plan', function () {
    $transaction = Paystack::client('foo')->plan();
    expect($transaction)->toBeInstanceOf(Plan::class);
});

test('has subscription', function () {
    $transaction = Paystack::client('foo')->subscription();
    expect($transaction)->toBeInstanceOf(Subscription::class);
});
