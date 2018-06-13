<?php

namespace App\Http\Controllers;

use App\Services\IIntentionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\TripCalculator;

class TripsController extends Controller
{
    /**
     * @var IIntentionService
     */
    private $intentions;

    public function __construct(IIntentionService $intentions)
	{
		$this->middleware('auth');
        $this->intentions = $intentions;
    }

    public function indexToday(){
        $consult_date = Carbon::today()->toDateString();

        return redirect()->route('trips', ['consult_date'=>$consult_date]);
    }

	public function index(Request $request)
	{
        $consult_date = $request->input('consult_date');
        if (!empty($consult_date)){
        	$consult_date = Carbon::createFromFormat('Y-m-d', $consult_date);
        }
        else $consult_date = Carbon::today();

        $trips = $this->intentions->getIntentions($consult_date);

        return view('trips.index', compact('trips', 'consult_date'));
	}

	public function show($consult_date, $id)
	{
        $consult_date = Carbon::createFromFormat('Y-m-d', $consult_date);

		$trip = $this->intentions->getIntentions($consult_date)[$id];

		$trips = $this->intentions->getIntentionsCompatibleWith($trip, false);

		//return $trips;
		return view('trips.show', compact('trips', 'trip'));
	}
}
