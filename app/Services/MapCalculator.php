<?php

namespace App\Services;

/**
 * Makes calculations usign the map
 */
class MapCalculator
{
	
	function __construct()
	{
		# code...
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
