<?php
declare(strict_types=1);
namespace Musheabdulhakim\Paystack\Contracts;

interface PaystackClientInterface {

     /**
     * Make Get Request to api endpoint.
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function get(string $url, array $query = []): mixed;

    /**
     * Make Post Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function post(string $url, array $query = []): mixed;

    /**
     * Make PUT Request to api endpoint
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function put(string $url, array $query = []): mixed;

}


