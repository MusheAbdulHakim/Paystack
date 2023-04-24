<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;


class Terminal
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendEvent(string $terminal_id, string $type, string $action, $data = []): mixed
    {
        $url = "terminal/{$terminal_id}/event";
        $params['type'] = $type;
        $params['action'] = $action;
        $params['data'] = $data;
        return $this->client->post($url, $params);
    }


    /**
     * Check the status of an event sent to the Terminal
     *
     * @param string $terminal_id The ID of the Terminal the event was sent to.
     * @param string $event_id The ID of the event that was sent to the Terminal
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#fetch-event-status
     */
    public function fetchEvent(string $terminal_id, string $event_id): mixed
    {
        $url = "terminal/{$terminal_id}/event/{$event_id}";
        return $this->client->get($url);
    }


    /**
     * Check the availiability of a Terminal before sending an event to it
     *
     * @param string $terminal_id The ID of the Terminal you want to check
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#fetch-terminal-status
     */
    public function status(string $terminal_id): mixed
    {
        $url = "terminal/{$terminal_id}/presence";
        return $this->client->get($url);
    }


    /**
     * List the Terminals available on your integration
     *
     * @param array|null $params Query Parameters
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#list
     */
    public function list(?array $params = []): mixed
    {
        return $this->client->get('terminal');
    }


    /**
     * Get the details of a Terminal
     *
     * @param string $terminal_id The ID of the Terminal the event was sent to.
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#fetch
     */
    public function terminal(string $terminal_id): mixed
    {
        $url = "terminal/{$terminal_id}";
        return $this->client->get($url);
    }


    /**
     * Update the details of a Terminal
     *
     * @param string $terminal_id The ID of the Terminal you want to update
     * @param string $name Name of the terminal
     * @param string $address Name of the terminal
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#update
     */
    public function update(string $terminal_id, string $name, string $address): mixed
    {
        $url = "terminal/{$terminal_id}";
        $params['name'] = $name;
        $params['address'] = $address;
        return $this->client->put($url, $params);
    }

    /**
     * Activate your debug device by linking it to your integration
     *
     * @param string $serial_number Device Serial Number
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#commission
     */
    public function commission(string $serial_number): mixed
    {
        $params['serial_number'] = $serial_number;
        return $this->client->post("terminal/commission_device", $params);
    }


    /**
     * Unlink your debug device from your integration
     *
     * @param string $serial_number Device Serial Number
     * @return mixed
     *
     * @link https://paystack.com/docs/api/terminal#decommission
     */
    public function decommission(string $serial_number): mixed
    {
        $params['serial_number'] = $serial_number;
        return $this->client->post("terminal/decommission_device", $params);
    }
}
