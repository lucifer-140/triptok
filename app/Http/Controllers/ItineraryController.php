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
        // Fetch the trip and itinerary details as before
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

        // Gemini API call for trip suggestions
        $destination = $trip->tripDestination;
        $tripDuration = $totalDays;

        // Cache key for the Gemini API calls
        $cacheKey = "trip_suggestions_{$trip_id}_{$destination}_{$totalDays}_{$tripGoals}";

        // Check if the suggestion data is cached, otherwise, generate it
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
            // Get the month from the start and end dates
            $startMonth = $startDate->format('F'); // Full month name (e.g., "March")
            $endMonth = $endDate->format('F'); // Full month name (e.g., "May")

            return Gemini::geminiPro()->generateContent(
                "Give the expected weather conditions for {$destination} in the {$destination} hemisphere from {$startMonth} to {$endMonth}, based on your own data."
            )->text();
        });





        $cultureTips = Cache::remember("culture_tips_{$cacheKey}", 60, function () use ($destination) {
            return Gemini::geminiPro()->generateContent(
                "Give 3 essential cultural etiquette tips for {$destination}, in a concise list."
            )->text();
        });

        // Fetch the grand_total values for each day
        $dayGrandTotals = $days->map(function($day) {
            return $day->grand_total; // Return the grand_total for each day
        });

        // Pass all data, including suggestions, to the view
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
            'trip_id' => 'required|exists:trips,id', // Ensure the trip exists
        ]);

        // Create a new itinerary
        $itinerary = Itinerary::create([
            'trip_id' => $request->trip_id,
        ]);

        return redirect()->route('itinerary.show', $itinerary->id)->with('success', 'Itinerary created successfully!');
    }


    public function save(Request $request)
    {
        // Log incoming request data for debugging
        \Log::info('Incoming request data:', $request->all());

        // Validate the incoming data
        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id', // Ensure itinerary_id exists in itineraries table
            'days' => 'required|array',
            'activities' => 'required|array',
            'transports' => 'required|array',
            'accommodations' => 'required|array',
            'flights' => 'required|array',
        ]);

        // Assuming itinerary_id is passed in the request
        foreach ($request->days as $dayData) {
            // Create a new Day entry
            $day = Day::create([
                'itinerary_id' => $request->itinerary_id, // Make sure to pass itinerary_id from your frontend
                'day' => $dayData['day'],
                'date' => $dayData['date'],
            ]);

            // Save associated data
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
