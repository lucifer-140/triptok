<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\SharedTrip;
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
        \Log::debug('Fetching trip with ID: ' . $trip_id);
        $trip = Trip::findOrFail($trip_id);
        \Log::debug('Trip retrieved: ', $trip->toArray());

        $validStatuses = ['ongoing', 'pending', 'finished'];

        \Log::debug('Validating status: ' . $status);
        // Step 1: Validate the provided status
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Step 2: Ensure the trip has an associated itinerary
        \Log::debug('Checking if trip has an itinerary');
        $itinerary = $trip->itineraries->first();  // Assumes one itinerary per trip
        if (!$itinerary) {
            \Log::debug('No itinerary found for trip');
            return redirect()->back()->with('error', 'No itinerary found for this trip.');
        }
        \Log::debug('Itinerary retrieved: ', $itinerary->toArray());

        // Step 3: Handle 'finished' status requirements
        \Log::debug('Checking if trip can end with status "finished"');
        if ($status === 'finished' && (!$trip->status || $trip->status->status === 'pending')) {
            \Log::debug('Cannot end trip: Status is either pending or not set');
            return redirect()->back()->with('error', 'Trip cannot end while status is pending or not set.');
        }

        // Step 4: For 'ongoing' or 'finished' status, validate days and activities
        if (in_array($status, ['ongoing', 'finished'])) {
            \Log::debug('Validating days and activities for status: ' . $status);

            $days = $itinerary->days->sortBy('day');
            \Log::debug('Days: ', $days->toArray());

            if ($days->isEmpty()) {
                \Log::debug('No days found in itinerary');
                return redirect()->back()->with('error', 'The itinerary must contain at least one day.');
            }

            $totalDays = $itinerary->totalDays ?? $days->count(); // Fallback to days count if totalDays is null
            \Log::debug('Total days: ' . $totalDays);

            // Ensure all days are present and sequential
            $missingDays = $this->getMissingDays($days, $totalDays);
            \Log::debug('Missing days: ', $missingDays);

            if (!empty($missingDays)) {
                return redirect()->back()->with('error', 'Missing day(s): ' . implode(', ', $missingDays) . '. All days must be present.');
            }

            // Verify each day has at least one activity
            foreach ($days as $day) {
                if ($day->activities->isEmpty()) {
                    \Log::debug('Day has no activities: ', $day->toArray());
                    return redirect()->back()->with('error', 'Each day must have at least one activity.');
                }
            }

            // Ensure 'finished' status can only be set from 'ongoing'
            if ($status === 'finished' && $trip->status->status !== 'ongoing') {
                \Log::debug('Cannot mark trip as finished: Status is not "ongoing"');
                return redirect()->back()->with('error', 'Trip must be ongoing to mark it as finished.');
            }
        }

        // Step 5: Update or create the trip status
        \Log::debug('Updating or creating trip status');
        TripStatus::updateOrCreate(
            ['trip_id' => $trip->id],
            ['status' => $status]
        );
        \Log::debug('Trip status updated to: ' . $status);

        // Redirect back with success message
        \Log::debug('Redirecting to trip list with success message');
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
        // Find the trip that is going to be deleted
        $trip = Trip::findOrFail($trip_id);

        // Optionally, check if the trip has a status that prevents deletion
        if ($trip->status && $trip->status->status === 'ongoing') {
            return redirect()->back()->with('error', 'You cannot delete an ongoing trip.');
        }

        // Check if this trip is a "new_trip" in the shared_trips table
        $sharedTrip = SharedTrip::where('new_trip', $trip_id)->first();

        // If the trip exists in the shared_trips table, delete the shared trip record
        if ($sharedTrip) {
            $sharedTrip->delete();
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

        $friends = Auth::user()->friends;


        // Check if the variables are being passed correctly
        return view('trips.tripList', compact('pendingTrips', 'ongoingTrips', 'finishedTrips', 'friends'));
    }



    public function showDetails($trip_id)
    {
        // Fetch the trip using the provided trip_id
        $trip = Trip::findOrFail($trip_id);
        $friends = Auth::user()->friends;


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
            'friends' => $friends,
        ]);
    }

    public function shareTrip(Request $request, $trip_id)
    {
        // Validate the selected friends (ensure they are users, and prevent sharing with self)
        $request->validate([
            'friends' => 'required|array',
            'friends.*' => 'exists:users,id|distinct',  // Ensure each ID corresponds to an existing user
        ]);

        // Fetch the trip
        $trip = Trip::findOrFail($trip_id);

        // Check if the user is the owner of the trip
        if ($trip->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only share your own trips.');
        }

        // Loop through selected friends and assign the trip to them
        foreach ($request->friends as $friend_id) {
            // Fetch the friend
            $friend = User::find($friend_id);

            // Ensure the user is not trying to share the trip with themselves
            if ($friend->id === Auth::id()) {
                continue;
            }

            // Duplicate the trip and assign it to the friend
            $newTrip = $trip->replicate();
            $newTrip->user_id = $friend->id;
            $newTrip->save();

            // Copy related data (e.g., itineraries, days, activities, etc.)
            $trip->itineraries->each(function ($itinerary) use ($newTrip) {
                $newItinerary = $itinerary->replicate();
                $newItinerary->trip_id = $newTrip->id;
                $newItinerary->save();

                // Copy days, activities, transports, accommodations, flights
                $itinerary->days->each(function ($day) use ($newItinerary) {
                    $newDay = $day->replicate();
                    $newDay->itinerary_id = $newItinerary->id;
                    $newDay->save();

                    $day->activities->each(function ($activity) use ($newDay) {
                        $newActivity = $activity->replicate();
                        $newActivity->day_id = $newDay->id;
                        $newActivity->save();
                    });

                    $day->transports->each(function ($transport) use ($newDay) {
                        $newTransport = $transport->replicate();
                        $newTransport->day_id = $newDay->id;
                        $newTransport->save();
                    });

                    $day->accommodations->each(function ($accommodation) use ($newDay) {
                        $newAccommodation = $accommodation->replicate();
                        $newAccommodation->day_id = $newDay->id;
                        $newAccommodation->save();
                    });

                    $day->flights->each(function ($flight) use ($newDay) {
                        $newFlight = $flight->replicate();
                        $newFlight->day_id = $newDay->id;
                        $newFlight->save();
                    });
                });
            });
        }

        return redirect()->back()->with('success', 'Trip successfully shared with your friends!');
    }




}
