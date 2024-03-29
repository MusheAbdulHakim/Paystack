<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Contracts;

interface PaystackClientInterface
{
    /**
    * Make Get Request to api endpoint.
    *
    * @param string $url
    * @param array $query
    * @return array
    */
    public function get(string $url, $query = []): array;

    /**
     * Make Post Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return array
     */
    public function post(string $url, $query = []): array;

    /**
     * Make PUT Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return array
     */
    public function put(string $url, $query = []): array;

    /**
     * Make DELETE Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return array
     */
    public function delete(string $url, $query = []): array;

}
