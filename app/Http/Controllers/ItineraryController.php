<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Itinerary;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function create($trip_id)
    {
        // Fetch the trip details using the trip ID
        $trip = Trip::findOrFail($trip_id);

        // Check if an itinerary already exists for this trip
        $itinerary = Itinerary::firstOrCreate(
            ['trip_id' => $trip_id],  // Condition to check for an existing itinerary
            ['trip_id' => $trip_id]   // Values to create if no existing itinerary
        );

        // Fetch the start and end dates and convert them to Carbon instances
        $startDate = Carbon::parse($trip->tripStartDate);
        $endDate = Carbon::parse($trip->tripEndDate);

        // Calculate the total number of days between start and end dates
        $totalDays = $startDate->diffInDays($endDate) + 1; // Adding 1 to include the start day

        // You can perform any actions with $totalDays here, like creating default itinerary entries

        // Pass only the itinerary, trip ID, and total days to the view
        return view('trips.itinerary', [
            'itinerary' => $itinerary,
            'trip_id' => $trip_id,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDays' => $totalDays, // Pass total days to the view if needed
            'currency' => $trip->currency,
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

    // public function show($id)
    // {
    //     $itinerary = Itinerary::with('days')->findOrFail($id);
    //     return view('itineraries.show', compact('itinerary'));
    // }
}
