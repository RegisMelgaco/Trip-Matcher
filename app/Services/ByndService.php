<?php

namespace App\Services;

use App\Trip;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class ByndService implements IIntentionService
{
    private $client;

    /**
     * ApiBynd constructor.
     * @param $baseUrl
     * @param $username
     * @param $password
     */
    public function __construct($baseUrl, $username, $password)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'auth' => [$username, $password]
        ]);
    }
    
    /**
     * Get all trips from specified date
     *
     * @param Carbon $date
     * @return Collection
     */
	public function getIntentions(Carbon $date): Collection
	{
        $data = $this->requestIntentions($date);
        $intentions = new Collection();

        foreach ($data as $item) {
            $trip = $this->buildTrip($item);
            $trip->save();
            $intentions->push($trip);
        }

        return $intentions;
    }

    /**
     * @param Carbon $date
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function requestIntentions(Carbon $date)
    {
        try {
            $response = $this->client->request('GET', '/api/v2/concierge/intentions?search_date=' . $date->toDateString());
            return json_decode($response->getBody()->getContents(), true)['data'];
        } catch (GuzzleException $e) {
            return [];
        }
    }

    /**
     * @param $item
     * @return Trip
     */
    private function buildTrip(array $item): Trip
    {
        $item['start_address_lat'] = $item['start_address']['location']['lat'];
        $item['start_address_lng'] = $item['start_address']['location']['lng'];
        $item['end_address_lat'] = $item['end_address']['location']['lat'];
        $item['end_address_lng'] = $item['end_address']['location']['lng'];
        $item['user_name'] = $item['user']['name'];

        $item['start_address'] = $item['start_address']['address'];
        $item['end_address'] = $item['end_address']['address'];

        return new Trip($item);
    }
}