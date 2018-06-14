<?php
/**
 * Created by PhpStorm.
 * User: regis
 * Date: 14/06/18
 * Time: 07:47
 */

namespace App\Services;


use App\Trip;
use Illuminate\Database\Eloquent\Builder;

class TripMatcher
{
    private $maxDist;

    /**
     * TripMatcher constructor.
     * @param $maxDist
     */
    public function __construct($maxDist)
    {
        $this->maxDist = $maxDist;
    }

    public function getMatchedTrips(Trip $trip)
    {
        return Trip::query()
            ->where('mode', $trip->isDriver() ? Trip::RIDER_MODE : Trip::DRIVER_MODE)
            ->whereBetween('schedule', [$trip->schedule->startOfDay(), $trip->schedule->endOfDay()])
            ->where(function (Builder $q) use ($trip) {
                return $q->whereRaw("pow(? - start_address_lat, 2) + pow(? - start_address_lng, 2) < ?", [
                    $trip->start_address_lat,
                    $trip->start_address_lng,
                    $this->maxDist
                ]);
            })
            ->where(function (Builder $q) use ($trip) {
                return $q->whereRaw("pow(? - end_address_lat, 2) + pow(? - end_address_lng, 2) < ?", [
                    $trip->end_address_lat,
                    $trip->end_address_lng,
                    $this->maxDist
                ]);
            })
            ->orderBy('schedule')
            ->get();
    }
}