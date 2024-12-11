<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Itinerary;
use App\Models\Trip;
use App\Models\Day;
use App\Models\Activity;
use App\Models\Transport;
use App\Models\Accommodation;
use App\Models\Flight;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Gemini\Laravel\Facades\Gemini;
use Google\Client;
use Google\Service\Customsearch;
use Illuminate\Support\Facades\Log;

class ItineraryController extends Controller
{


    public function create($trip_id)
    {

        $trip = Trip::findOrFail($trip_id);
        $itinerary = Itinerary::firstOrCreate(['trip_id' => $trip_id], ['trip_id' => $trip_id]);
        $days = $itinerary->days->sortBy('date');
        $grandTotal = $days->sum('grand_total');
        $totalBudget = $trip->totalBudget;
        $leftover = $totalBudget - $grandTotal;
        $startDate = Carbon::parse($trip->tripStartDate);
        $endDate = Carbon::parse($trip->tripEndDate);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $currencies = Currency::all();
        $tripStatus = $trip->status;
        $tripGoals = $trip->goals;
        $statusMessage = $tripStatus ? $tripStatus : 'Status not set yet';
        $friends = Auth::user()->friends;


        $destination = $trip->tripDestination;
        $tripDuration = $totalDays;


        $cacheKey = "trip_suggestions_{$trip_id}_{$destination}_{$totalDays}_{$tripGoals}";


        $budgetTips = Cache::remember("budget_tips_{$cacheKey}", 60, function () use ($trip, $tripDuration, $destination, $tripGoals) {
            return Gemini::geminiPro()->generateContent(
                "If {$trip->currency}{$trip->totalBudget} is not enough for a {$tripDuration}-day trip to {$destination}, with the goal of {$tripGoals}, provide a concise short budget breakdown like this:

                * **Flights:** {$trip->currency}[estimated cost]
                * **Accommodation:** {$trip->currency}[estimated cost]
                * **Activities:** {$trip->currency}[estimated cost]
                * **Food:** {$trip->currency}[estimated cost]
                * **Total:** {$trip->currency}[estimated total]

                Ensure the estimated costs are appropriate for {$destination} and {$tripDuration}."
            )->text();
        });

        $weatherInfo = Cache::remember("weather_info_{$cacheKey}", 60, function () use ($startDate, $endDate, $destination) {

            $startMonth = $startDate->format('F');
            $endMonth = $endDate->format('F');


            $dateRange = $startMonth === $endMonth
                ? $startMonth
                : "{$startMonth} to {$endMonth}";


            return Gemini::geminiPro()->generateContent(
                "What are the main weather conditions someone traveling to {$destination} during {$dateRange} should know about? Provide necessary details only."
            )->text();
        });


        $cultureTips = Cache::remember("culture_tips_{$cacheKey}", 60, function () use ($destination) {
            return Gemini::geminiPro()->generateContent(
                "Give 3 essential cultural etiquette tips for {$destination}, in a concise list."
            )->text();
        });


        $dayGrandTotals = $days->map(function($day) {
            return $day->grand_total;
        });


        return view('trips.itinerary', [
            'itinerary' => $itinerary,
            'trip' => $trip,
            'trip_id' => $trip_id,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDays' => $totalDays,
            'grandTotal' => $grandTotal,
            'currency' => $trip->currency,
            'totalBudget' => $totalBudget,
            'leftover' => $leftover,
            'days' => $days,
            'currencies' => $currencies,
            'tripStatus' => $tripStatus,
            'budgetTips' => $budgetTips,
            'weatherInfo' => $weatherInfo,
            'cultureTips' => $cultureTips,
            'tripGoals' => $tripGoals,
            'dayGrandTotals' => $dayGrandTotals,
            'tripStatus' => $statusMessage,
            'friends' => $friends
        ]);
    }






    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);


        $itinerary = Itinerary::create([
            'trip_id' => $request->trip_id,
        ]);

        return redirect()->route('itinerary.show', $itinerary->id)->with('success', 'Itinerary created successfully!');
    }


    public function save(Request $request)
    {

        \Log::info('Incoming request data:', $request->all());


        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id',
            'days' => 'required|array',
            'activities' => 'required|array',
            'transports' => 'required|array',
            'accommodations' => 'required|array',
            'flights' => 'required|array',
        ]);


        foreach ($request->days as $dayData) {

            $day = Day::create([
                'itinerary_id' => $request->itinerary_id,
                'day' => $dayData['day'],
                'date' => $dayData['date'],
            ]);


            foreach ($request->activities as $activity) {
                $day->activities()->create($activity);
            }
            foreach ($request->transports as $transport) {
                $day->transports()->create($transport);
            }
            foreach ($request->accommodations as $accommodation) {
                $day->accommodations()->create($accommodation);
            }
            foreach ($request->flights as $flight) {
                $day->flights()->create($flight);
            }
        }
        dd($request->all());

        return response()->json(['message' => 'Itinerary saved successfully.']);
    }





}
