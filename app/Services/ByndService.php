<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use App\Services\IIntentionService;

use App\Services\TripCalculator;

class ByndService implements IIntentionService
{
    private $client;

    /**
     * ApiBynd constructor.
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
     * @return array
     */
	public function getIntentions(Carbon $date)
	{
        try {
            $res = $this->client->request('GET', '/api/v2/concierge/intentions?search_date='.$date->toDateString());
            return json_decode($res->getBody(), true)['data'];
        } catch (GuzzleException $e) {
            return [];
        }
	}

    /**
     * Get all trips campatible with $trip
     *
     * @param array $trip:
     * @return array
     */
    public function getIntentionsCompatibleWith($trip, $with_equals_mode=true)
    {
        $schedule = Carbon::createFromFormat('Y-m-d H:i:s', $trip['schedule']);
        $end_schedule = Carbon::createFromFormat('Y-m-d H:i:s', $trip['end_schedule']);

        $compatible_trips = [];
        $anterior_trips = [];
        $trips = [];
        while ($schedule->diffInDays($end_schedule) > 0){
            while ($anterior_trips == $trips) {
                $schedule->addDay();
                $trips = $this->getIntentions($schedule);
            }
            $anterior_trips = $trips;
            if (!empty($trips)){
                $new_compatible_trips = TripCalculator::getCompatibleIntetionsFrom($trips, $trip);
                $compatible_trips = array_merge($compatible_trips, $new_compatible_trips);
            }
        }

        return $compatible_trips;
    }
}