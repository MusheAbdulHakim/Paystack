<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack;

class Client
{
    private $secret_key;

    private $base_url;

    private $http;

    public function __construct($secret_key, $base_url)
    {
        $this->base_url = $base_url;
        $this->secret_key = $secret_key;

        $this->http = new \GuzzleHttp\Client([
            'base_uri' => $this->base_url
        ]);
    }


    /**
     * Make Get Request to api endpoint.
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function get(string $url, array $query = []): mixed
    {
        try {
            $response = $this->http->get($url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->secret_key}",
                    'Accept'        => "application/json",
                    'Cache-Control' => "no-cache"
                ],
                'query' => $query
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Make Post Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function post(string $url, array $query = []): mixed
    {
        try {
            $response = $this->http->post($url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->secret_key}",
                    'Cache-Control' => "no-cache"
                ],
                'form_params' => $query,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getMessage();
        }
    }


    /**
     * Make PUT Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function put(string $url, array $query = []): mixed
    {
        try {
            $response = $this->http->put($url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->secret_key}",
                    'Cache-Control' => "no-cache"
                ],
                'form_params' => $query,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getMessage();
        }
    }

    public function curlPost(string $url, array $query = [])
    {
        $url = $this->base_url.'/'.$url;
        if((substr($this->base_url, -1) === '/')) {
            $url = $this->base_url.$url;
        }
        $fields_string = http_build_query($query);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".$this->secret_key,
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        return $response;
    }
}
