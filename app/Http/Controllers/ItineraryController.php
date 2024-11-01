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




    // public function show($id)
    // {
    //     $itinerary = Itinerary::with('days')->findOrFail($id);
    //     return view('itineraries.show', compact('itinerary'));
    // }
}
