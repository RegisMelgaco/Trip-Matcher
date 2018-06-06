<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiBynd;
use App\Services\MapCalculator;

class TripsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$date = $request->input('dataConsulta');

		if ($date) {
			$apibynd = new ApiBynd();
			$trips = $apibynd->accessDate($date);

			return view('trips_index')->with('trips', $trips);
		} else {
			return view('trips_index')->with('trips', False);
		}
	}

	public function route($date, $id)
	{
		$maxDistance = 0.5;
		$trips = ApiBynd::accessDate($date);
		$trip = $trips[$id];

		$compatibleTrips = [];

		for ($i=0; $i < count($trips); $i++) { 
			if ($i == $id) {
				continue;
			} else {
				if ($trip['mode'] != $trips[$i]['mode']) {
					$startsDistance =  MapCalculator::cooordinatesDistance($trip['start_address']['location'], $trips[$i]['start_address']['location']);
					$endDistance = MapCalculator::cooordinatesDistance($trip['end_address']['location'], $trips[$i]['end_address']['location']);

					if ($startsDistance <= $maxDistance && $endDistance <= $maxDistance) {
						$compatibleTrips += $trips[$i];
					}
				}
			}
		}

		return $compatibleTrips;
	}
}
