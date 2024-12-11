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

        $request->validate([
            'tripTitle' => 'required|string|max:255',
            'tripDestination' => 'required|string|max:255',
            'tripStartDate' => 'required|date',
            'tripEndDate' => 'required|date|after_or_equal:tripStartDate',
            'totalBudget' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'goals' => 'nullable|string|max:1000',
        ]);


        $trip = new Trip();
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->goals = $request->goals;
        $trip->user_id = Auth::id();
        $trip->save();


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


        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->goals = $request->goals;


        $trip->save();


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

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }


        \Log::debug('Checking if trip has an itinerary');
        $itinerary = $trip->itineraries->first();
        if (!$itinerary) {
            \Log::debug('No itinerary found for trip');
            return redirect()->back()->with('error', 'No itinerary found for this trip.');
        }
        \Log::debug('Itinerary retrieved: ', $itinerary->toArray());


        \Log::debug('Checking if trip can end with status "finished"');
        if ($status === 'finished' && (!$trip->status || $trip->status->status === 'pending')) {
            \Log::debug('Cannot end trip: Status is either pending or not set');
            return redirect()->back()->with('error', 'Trip cannot end while status is pending or not set.');
        }


        if (in_array($status, ['ongoing', 'finished'])) {
            \Log::debug('Validating days and activities for status: ' . $status);

            $days = $itinerary->days->sortBy('day');
            \Log::debug('Days: ', $days->toArray());

            if ($days->isEmpty()) {
                \Log::debug('No days found in itinerary');
                return redirect()->back()->with('error', 'The itinerary must contain at least one day.');
            }

            $totalDays = $itinerary->totalDays ?? $days->count();
            \Log::debug('Total days: ' . $totalDays);


            $missingDays = $this->getMissingDays($days, $totalDays);
            \Log::debug('Missing days: ', $missingDays);

            if (!empty($missingDays)) {
                return redirect()->back()->with('error', 'Missing day(s): ' . implode(', ', $missingDays) . '. All days must be present.');
            }


            foreach ($days as $day) {
                if ($day->activities->isEmpty()) {
                    \Log::debug('Day has no activities: ', $day->toArray());
                    return redirect()->back()->with('error', 'Each day must have at least one activity.');
                }
            }


            if ($status === 'finished' && $trip->status->status !== 'ongoing') {
                \Log::debug('Cannot mark trip as finished: Status is not "ongoing"');
                return redirect()->back()->with('error', 'Trip must be ongoing to mark it as finished.');
            }
        }


        \Log::debug('Updating or creating trip status');
        TripStatus::updateOrCreate(
            ['trip_id' => $trip->id],
            ['status' => $status]
        );
        \Log::debug('Trip status updated to: ' . $status);


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

        $trip = Trip::findOrFail($trip_id);


        if ($trip->status && $trip->status->status === 'ongoing') {
            return redirect()->back()->with('error', 'You cannot delete an ongoing trip.');
        }


        $sharedTrip = SharedTrip::where('new_trip', $trip_id)->first();


        if ($sharedTrip) {
            $sharedTrip->delete();
        }


        $trip->itineraries()->delete();
        $trip->delete();

        return redirect()->route('tripList')->with('success', 'Trip deleted successfully.');
    }



    public function tripList()
    {
        

        $pendingTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'pending');
        })->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        $ongoingTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'ongoing');
        })->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        $finishedTrips = Trip::whereHas('status', function ($query) {
            $query->where('status', 'finished');
        })->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        $friends = Auth::user()->friends;



        return view('trips.tripList', compact('pendingTrips', 'ongoingTrips', 'finishedTrips', 'friends'));
    }



    public function showDetails($trip_id)
    {

        $trip = Trip::findOrFail($trip_id);
        $friends = Auth::user()->friends;



        $itinerary = $trip->itineraries()->first();


        if (!$itinerary) {
            return back()->with('error', 'No itinerary found for this trip.');
        }


        $days = $itinerary->days()->with(['activities', 'accommodations', 'transports', 'flights'])->get();


        $totalDays = Carbon::parse($trip->start_date)->diffInDays(Carbon::parse($trip->end_date)) + 1;


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

        $request->validate([
            'friends' => 'required|array',
            'friends.*' => 'exists:users,id|distinct',
        ]);


        $trip = Trip::findOrFail($trip_id);


        if ($trip->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only share your own trips.');
        }


        foreach ($request->friends as $friend_id) {

            $friend = User::find($friend_id);


            if ($friend->id === Auth::id()) {
                continue;
            }


            $newTrip = $trip->replicate();
            $newTrip->user_id = $friend->id;
            $newTrip->save();


            $trip->itineraries->each(function ($itinerary) use ($newTrip) {
                $newItinerary = $itinerary->replicate();
                $newItinerary->trip_id = $newTrip->id;
                $newItinerary->save();


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
