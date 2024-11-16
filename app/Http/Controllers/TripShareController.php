<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Models\SharedTrip;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class TripShareController extends Controller
{
    // Method to show the sharing modal
    public function create($trip_id)
    {
        // Fetch the trip and user's friends
        $trip = Trip::findOrFail($trip_id);
        $friends = Auth::user()->friends;

        // Pass the trip data and friends to the modal view
        return view('components.share-trip-modal', [
            'trip' => $trip,
            'friends' => $friends
        ]);
    }

    public function share(Request $request, $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);
        $friends = User::find($request->friends);  // The friends selected to share the trip

        foreach ($friends as $friend) {
            // Create a new entry in the shared_trips table with the status "pending"
            SharedTrip::create([
                'user_id' => $friend->id,
                'trip_id' => $trip_id,
                'status' => 'pending',
            ]);
        }

        return back()->with('success', 'Trip shared successfully!');
    }

    public function accept($sharedTripId)
    {
        // Find the shared trip by its ID
        $sharedTrip = SharedTrip::findOrFail($sharedTripId);

        // Ensure the status is pending
        if ($sharedTrip->status != 'pending') {
            return back()->with('error', 'This trip has already been accepted or rejected.');
        }

        // Start the transaction to ensure data consistency
        DB::beginTransaction();

        try {
            // Check if the current user is the recipient
            if ($sharedTrip->user_id !== auth()->id()) {
                return redirect()->route('trips.index')->with('error', 'You cannot accept this trip.');
            }

            // Update the status to 'accepted'
            $sharedTrip->status = 'accepted';
            $sharedTrip->save();

            // Duplicate the trip (create a new trip for the receiver)
            $originalTrip = $sharedTrip->trip;
            $newTrip = $originalTrip->replicate();
            $newTrip->user_id = auth()->id(); // Set the new user's ID (the receiver)
            $newTrip->save();

            // Duplicate related tables like itinerary, expenses, etc.
            // Replicate itinerary and related models
            $originalItinerary = Itinerary::where('trip_id', $originalTrip->id)->first();
            $newItinerary = $originalItinerary->replicate();
            $newItinerary->trip_id = $newTrip->id;
            $newItinerary->save();

            // Duplicate days and other related data
            foreach ($originalItinerary->days as $originalDay) {
                $newDay = $originalDay->replicate();
                $newDay->itinerary_id = $newItinerary->id;
                $newDay->save();

                // Duplicate activities, transports, accommodations, flights for the day
                foreach ($originalDay->activities as $activity) {
                    $newActivity = $activity->replicate();
                    $newActivity->day_id = $newDay->id;
                    $newActivity->save();
                }

                foreach ($originalDay->transports as $transport) {
                    $newTransport = $transport->replicate();
                    $newTransport->day_id = $newDay->id;
                    $newTransport->save();
                }

                foreach ($originalDay->accommodations as $accommodation) {
                    $newAccommodation = $accommodation->replicate();
                    $newAccommodation->day_id = $newDay->id;
                    $newAccommodation->save();
                }

                foreach ($originalDay->flights as $flight) {
                    $newFlight = $flight->replicate();
                    $newFlight->day_id = $newDay->id;
                    $newFlight->save();
                }
            }

            // Duplicate the trip status
            $originalTripStatus = $originalTrip->status;
            $newTripStatus = $originalTripStatus->replicate();
            $newTripStatus->trip_id = $newTrip->id;
            $newTripStatus->save();

            // Store the new trip ID in the shared_trips table in the 'new_trip' column
            $sharedTrip->new_trip = $newTrip->id;
            $sharedTrip->save();

            // Commit the transaction
            DB::commit();

            // Redirect to the new trip's page
            return back()->with('success', 'Trip shared successfully and accepted!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in trip acceptance: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'There was an error processing your request. Please try again.');
        }

    }

    public function reject($shared_trip_id)
    {
        $sharedTrip = SharedTrip::findOrFail($shared_trip_id);

        // Delete the row from the database
        $sharedTrip->delete();

        return back()->with('success', 'Trip rejected and removed.');
    }


    public function notifications()
    {
        // Fetch all the shared trips where the user is the receiver
        $sharedTrips = SharedTrip::where('user_id', auth()->id())
                                ->where('status', 'pending')
                                ->get();

        return view('notifications', compact('sharedTrips'));
    }





}
