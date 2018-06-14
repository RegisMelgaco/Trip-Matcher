<?php

namespace App\Http\Controllers;

use App\Services\IIntentionService;
use App\Services\TripMatcher;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * @var IIntentionService
     */
    private $service;

    private $matcher;

    public function __construct(IIntentionService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
        $this->matcher = new TripMatcher(0.002);
    }

    public function index(Request $request)
    {
        $consult_date = $request->input('consult_date');
        if (!empty($consult_date))
            $consult_date = Carbon::createFromFormat('Y-m-d', $consult_date);
        else
            $consult_date = Carbon::today();

        $trips = $this->service->getIntentions($consult_date);

        return view('trips.index', compact('consult_date', 'trips'));
    }

    public function show(Trip $trip)
    {
        $trips = $this->matcher->getMatchedTrips($trip);

		return view('trips.show', compact('trips', 'trip'));
	}
}
