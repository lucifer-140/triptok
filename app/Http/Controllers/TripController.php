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
            'goals' => 'nullable|string|max:1000',
        ]);

        // Create a new trip instance and save it to the database
        $trip = new Trip();
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->goals = $request->goals;
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
            'goals' => 'nullable|string|max:1000',
        ]);

        $trip = Trip::findOrFail($id);

        // Assign each attribute individually
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->goals = $request->goals;

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

        // Step 1: Validate the provided status
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Step 2: Ensure the trip has an associated itinerary
        $itinerary = $trip->itineraries->first();  // Assumes one itinerary per trip
        if (!$itinerary) {
            return redirect()->back()->with('error', 'No itinerary found for this trip.');
        }

        // Step 3: Handle 'finished' status requirements
        if ($status === 'finished' && (!$trip->status || $trip->status->status === 'pending')) {
            return redirect()->back()->with('error', 'Trip cannot end while status is pending or not set.');
        }

        // Step 4: For 'ongoing' or 'finished' status, validate days and activities
        if (in_array($status, ['ongoing', 'finished'])) {
            $days = $itinerary->days->sortBy('day');
            $totalDays = $itinerary->totalDays ?? $days->count(); // Fallback to days count if totalDays is null

            // Ensure all days are present and sequential
            $missingDays = $this->getMissingDays($days, $totalDays);
            if (!empty($missingDays)) {
                return redirect()->back()->with('error', 'Missing day(s): ' . implode(', ', $missingDays) . '. All days must be present.');
            }

            // Verify each day has at least one activity
            foreach ($days as $day) {
                if ($day->activities->isEmpty()) {
                    return redirect()->back()->with('error', 'Each day must have at least one activity.');
                }
            }

            // Ensure 'finished' status can only be set from 'ongoing'
            if ($status === 'finished' && $trip->status->status !== 'ongoing') {
                return redirect()->back()->with('error', 'Trip must be ongoing to mark it as finished.');
            }
        }

        // Step 5: Update or create the trip status
        TripStatus::updateOrCreate(
            ['trip_id' => $trip->id],
            ['status' => $status]
        );

        // Redirect back with success message
        return redirect()->route('tripList')->with('success', 'Trip status updated to ' . ucfirst($status));
    }

    /**
     * Helper function to check for missing days in the itinerary.
     *
     * @param Collection $days
     * @param int $totalDays
     * @return array
     */
    private function getMissingDays($days, $totalDays)
    {
        $missingDays = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            if (!$days->contains('day', $i)) {
                $missingDays[] = $i;
            }
        }
        return $missingDays;
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
            'trip_id' => $trip->id,
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
