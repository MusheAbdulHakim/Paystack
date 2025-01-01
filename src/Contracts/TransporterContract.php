<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts;

use MusheAbdulHakim\Paystack\Exceptions\ErrorException;
use MusheAbdulHakim\Paystack\Exceptions\TransporterException;
use MusheAbdulHakim\Paystack\Exceptions\UnserializableResponse;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Response;
use Psr\Http\Message\ResponseInterface;

interface TransporterContract
{
    /**
     * Sends a request to a server.
     *
     *
     * @throws ErrorException|UnserializableResponse|TransporterException
     */
    public function requestObject(Payload $payload): Response;

    /**
     * Sends a content request to a server.
     *
     * @throws ErrorException|TransporterException
     */
    public function requestContent(Payload $payload): string;

    /**
     * Sends a stream request to a server.
     **
     * @throws ErrorException
     */
    public function requestStream(Payload $payload): ResponseInterface;
}
