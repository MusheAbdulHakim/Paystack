<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

final class TransporterException extends Exception
{
    /**
     * Creates a new Exception instance.
     */
    public function __construct(ClientExceptionInterface $exception)
    {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
