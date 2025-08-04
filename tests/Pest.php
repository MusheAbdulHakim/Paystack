<?php

use Mockery;
use MusheAbdulHakim\Paystack\Client;
use MusheAbdulHakim\Paystack\Contracts\TransporterContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\ApiKey;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\BaseUri;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Headers;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\QueryParams;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Response;
use Psr\Http\Message\ResponseInterface;

function mockClient(string $method, string $endpoint, array $params, Response|ResponseInterface|string $response, $methodName = 'requestObject', bool $validateParams = true)
{
    $transporter = Mockery::mock(TransporterContract::class);

    $transporter
        ->shouldReceive($methodName)
        ->once()
        ->withArgs(function (Payload $payload) use ($validateParams, $method, $endpoint, $params) {
            $baseUri = BaseUri::from('https://api.paystack.co');
            $headers = Headers::withAuthorization(ApiKey::from('foo'));
            $queryParams = QueryParams::create();

            $request = $payload->toRequest($baseUri, $headers, $queryParams);

            if ($validateParams) {
                if (in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
                    if ($request->getUri()->getQuery() !== http_build_query($params)) {
                        return false;
                    }
                } else {
                    if ($request->getBody()->getContents() !== json_encode($params)) {
                        return false;
                    }
                }
            }

            return $request->getMethod() === $method
                && $request->getUri()->getPath() === "$endpoint";
        })->andReturn($response);

    return new Client($transporter);
}

function mockContentClient(string $method, string $resource, array $params, string $response, bool $validateParams = true)
{
    return mockClient($method, $resource, $params, $response, 'requestContent', $validateParams);
}
