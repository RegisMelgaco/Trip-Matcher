<?php
/**
 * Created by PhpStorm.
 * User: regis
 * Date: 12/06/18
 * Time: 07:07
 */

namespace App\Services;


class TripCalculator
{
    static function getCompatibleIntetionsFrom($trips, $trip, $with_equals_mode=false)
    {
        $max_distance = config('services.trips_caculator.max_distance');
        for ($i = 0; $i < count($trips); $i++){

            $start_distance = TripCalculator::cooordinatesDistance($trip['start_address']['location'], $trips[$i]['start_address']['location']);
            if ($start_distance > $max_distance) {
                unset($trips[$i]);
                continue;
            }

            $end_distance = TripCalculator::cooordinatesDistance($trip['end_address']['location'], $trips[$i]['end_address']['location']);
            if ($end_distance > $max_distance) {
                unset($trips[$i]);
                continue;
            }

            if ($trip['mode'] == $trips[$i]['mode'] && false) {
                unset($trips[$i]);
                continue;
            }

            if ($trips[$i] == $trip) unset($trips[$i]);
        }
        return $trips;
    }

    static function cooordinatesDistance($cooordinate1, $cooordinate2)
    {
        $lat1 = deg2rad($cooordinate1['lat']);
        $lon1 = deg2rad($cooordinate1['lng']);
        $lat2 = deg2rad($cooordinate2['lat']);
        $lon2 = deg2rad($cooordinate2['lng']);
        $dist = (6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin($lat2) ) );
        $dist = number_format($dist, 2, '.', '');
        return $dist;
    }
}