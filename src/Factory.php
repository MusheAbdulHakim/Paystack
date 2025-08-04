<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

use Closure;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Http\Discovery\Psr18Client;
use Http\Discovery\Psr18ClientDiscovery;
use MusheAbdulHakim\Paystack\Transporters\HttpTransporter;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\ApiKey;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\BaseUri;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Headers;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\QueryParams;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Factory
{
    /**
     * The base URI for the requests.
     */
    private ?string $baseUri = 'https://api.paystack.co';

    /**
     * The API key for the requests.
     */
    private ?string $secretKey = null;

    private ?string $publicKey = null;

    /**
     * The HTTP client for the requests.
     */
    private ?ClientInterface $httpClient = null;

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    private array $headers = [];

    private ?Closure $streamHandler = null;

    /**
     * The query parameters for the requests.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    /**
     * Sets the API key for the requests.
     */
    public function withSecretKey(string $secretKey): self
    {
        $this->secretKey = trim($secretKey);

        return $this;
    }

    public function withPublicKey(string $publicKey): self
    {
        $this->publicKey = trim($publicKey);

        return $this;
    }

    /**
     * Sets the base URI for the requests.
     * If no URI is provided the factory will use the default OpenAI API URI.
     */
    public function withBaseUri(string $baseUri): self
    {
        $this->baseUri = trim($baseUri);

        return $this;
    }

    /**
     * Sets the HTTP client for the requests.
     * If no client is provided the factory will try to find one using PSR-18 HTTP Client Discovery.
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Sets the stream handler for the requests. Not required when using Guzzle.
     */
    public function withStreamHandler(Closure $streamHandler): self
    {
        $this->streamHandler = $streamHandler;

        return $this;
    }

    /**
     * Adds a custom HTTP header to the requests.
     */
    public function withHttpHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Adds a Content-Type HTTP header to the requests.
     */
    public function withContentType(string $value): self
    {
        $this->headers['Content-Type'] = $value;

        return $this;
    }

    /**
     * Adds a custom query parameter to the request url.
     */
    public function withQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * Creates a new stream handler for "stream" requests.
     */
    private function makeStreamHandler(ClientInterface $client): Closure
    {
        if (! is_null($this->streamHandler)) {
            return $this->streamHandler;
        }

        if ($client instanceof GuzzleClient) {
            return fn (RequestInterface $request): ResponseInterface => $client->send($request, ['stream' => true]);
        }

        if ($client instanceof Psr18Client) {
            return fn (RequestInterface $request): ResponseInterface => $client->sendRequest($request);
        }

        return function (RequestInterface $_): never {
            throw new Exception('To use stream requests you must provide an stream handler closure via the OpenAI factory.');
        };
    }

    public function make(): Client
    {
        $headers = Headers::create();

        $headers = Headers::withAuthorization(ApiKey::from(
            $this->secretKey !== null && $this->secretKey !== '' && $this->secretKey !== '0' ? $this->secretKey : ''
        ));

        foreach ($this->headers as $name => $value) {
            $headers = $headers->withCustomHeader($name, $value);
        }

        $baseUri = BaseUri::from(
            $this->baseUri !== null && $this->baseUri !== '' && $this->baseUri !== '0' ? $this->baseUri : 'https://api.paystack.co',
        );

        $queryParams = QueryParams::create();
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }
        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $sendAsync = $this->makeStreamHandler($client);

        $transporter = new HttpTransporter($client, $baseUri, $headers, $queryParams, $sendAsync);

        return new Client($transporter);
    }
}
