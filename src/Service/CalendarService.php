<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Http\Client;

class CalendarService
{
    /**
     * @var \Cake\Http\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCalendarList()
    {
        // Do something with $this->client.
        $response = $this->client->get('https://calendar.google.com/api/1');
        $data = $response->getJson();

        return $data ?? [];
    }
}
