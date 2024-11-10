<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Currency;
use App\Models\TripStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function create()
    {
        $currencies = Currency::all();
        return view('trips.create-trip', compact('currencies'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'tripTitle' => 'required|string|max:255',
            'tripDestination' => 'required|string|max:255',
            'tripStartDate' => 'required|date',
            'tripEndDate' => 'required|date|after_or_equal:tripStartDate',
            'totalBudget' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        // Create a new trip instance and save it to the database
        $trip = new Trip();
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->user_id = Auth::id(); // Associate the trip with the authenticated user
        $trip->save();

        // Redirect to the itinerary creation page with the trip ID
        return redirect()->route('itinerary.create', ['trip' => $trip->id])
                        ->with('success', 'Trip created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tripTitle' => 'required|string|max:255',
            'tripDestination' => 'required|string|max:255',
            'tripStartDate' => 'required|date',
            'tripEndDate' => 'required|date|after_or_equal:tripStartDate',
            'totalBudget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
        ]);

        $trip = Trip::findOrFail($id);

        // Assign each attribute individually
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;

        // Save the updated trip to the database
        $trip->save();

        // Redirect to the itinerary creation page with the trip ID
        return redirect()->route('itinerary.create', ['trip' => $trip->id])
                        ->with('success', 'Trip details updated successfully.');

    }

    public function updateStatus($trip_id, $status)
    {
        $trip = Trip::findOrFail($trip_id);
        $validStatuses = ['ongoing', 'pending', 'finished'];

        // Step 1: Validate that the status is valid
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Step 2: Validate that the trip has an associated itinerary
        $itinerary = $trip->itineraries->first();  // Assuming one itinerary per trip

        if (!$itinerary) {
            return redirect()->back()->with('error', 'No itinerary found for this trip.');
        }

        // Step 3: Check if the current status is either 'pending' or null before allowing to finish the trip
        if ($status === 'finished') {
            if ($trip->status === null || $trip->status->status === 'pending') {
                return redirect()->back()->with('error', 'You cannot end the trip when the status is pending or not set.');
            }
        }

        // Only perform the following checks if the status is 'ongoing' or 'finished'
        if ($status === 'ongoing' || $status === 'finished') {
            // Step 4: Ensure that all days are present in the itinerary and sequential
            $days = $itinerary->days->sortBy('day');
            $totalDays = $itinerary->totalDays;
            $daysMissing = [];

            // Check for missing days and ensure the days are sequential
            for ($i = 1; $i <= $totalDays; $i++) {
                if (!$days->contains('day', $i)) {
                    $daysMissing[] = $i;
                }
            }

            // Check for missing days and return error if any
            if (count($daysMissing) > 0) {
                return redirect()->back()->with('error', 'Missing day(s): ' . implode(', ', $daysMissing) . '. All days must be present.');
            }

            // Step 5: Ensure there are exactly the correct number of days
            if ($days->count() !== $totalDays) {
                return redirect()->back()->with('error', 'The number of days in the itinerary does not match the expected total days.');
            }

            // Step 6: Check if each day has at least one activity
            foreach ($days as $day) {
                if ($day->activities->count() < 1) {
                    return redirect()->back()->with('error', 'Each day must have at least one activity.');
                }
            }

            // Step 7: If status is 'finished', check if the trip is 'ongoing'
            if ($status === 'finished' && ($trip->status && $trip->status->status !== 'ongoing')) {
                return redirect()->back()->with('error', 'Trip must be ongoing to mark it as finished.');
            }
        }

        // Step 8: Update or create the trip status
        TripStatus::updateOrCreate(
            ['trip_id' => $trip->id],
            ['status' => $status]
        );

        // Redirect back with success message
        return redirect()->route('tripList')->with('success', 'Trip status updated to ' . ucfirst($status));
    }



    public function destroy($trip_id)
    {
        $trip = Trip::findOrFail($trip_id);

        // Optionally, check if the trip has a status that prevents deletion
        if ($trip->status && $trip->status->status === 'ongoing') {
            return redirect()->back()->with('error', 'You cannot delete an ongoing trip.');
        }

        // Delete the trip and associated data (itinerary, days, etc.)
        $trip->itineraries()->delete();  // Deleting related itineraries
        $trip->delete();  // Delete the trip itself

        return redirect()->route('tripList')->with('success', 'Trip deleted successfully.');
    }



    public function tripList()
    {
        // Retrieve trips for each status, ordered by the latest first, and belonging to the authenticated user

        $pendingTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'pending');
        })->where('user_id', Auth::id()) // Only trips belonging to the authenticated user
        ->orderBy('created_at', 'desc')
        ->get();

        $ongoingTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'ongoing');
        })->where('user_id', Auth::id()) // Only trips belonging to the authenticated user
        ->orderBy('created_at', 'desc')
        ->get();

        $finishedTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'finished');
        })->where('user_id', Auth::id()) // Only trips belonging to the authenticated user
        ->orderBy('created_at', 'desc')
        ->get();

        // Check if the variables are being passed correctly
        return view('trips.tripList', compact('pendingTrips', 'ongoingTrips', 'finishedTrips'));
    }



    public function showDetails($trip_id)
    {
        // Fetch the trip using the provided trip_id
        $trip = Trip::findOrFail($trip_id);

        // Retrieve the first itinerary associated with the trip
        $itinerary = $trip->itineraries()->first();

        // Check if an itinerary is found
        if (!$itinerary) {
            return back()->with('error', 'No itinerary found for this trip.');
        }

        // Fetch days and load all related data (activities, accommodations, transports, flights)
        $days = $itinerary->days()->with(['activities', 'accommodations', 'transports', 'flights'])->get();

        // Calculate the total days
        $totalDays = Carbon::parse($trip->start_date)->diffInDays(Carbon::parse($trip->end_date)) + 1;

        // Return the view with all relevant data
        return view('trips.tripDetails', [
            'trip' => $trip,
            'itinerary' => $itinerary,
            'days' => $days,
            'totalDays' => $totalDays,
        ]);
    }









    public function index()
    {
        // Get trips that belong to the authenticated user
        $trips = Trip::where('user_id', Auth::id())->get();
        return view('trips.list', compact('trips'));
    }

    public function show($id)
    {
        // Attempt to find the trip by ID and check if it belongs to the authenticated user
        $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('trips.details', compact('trip'));
    }



}
