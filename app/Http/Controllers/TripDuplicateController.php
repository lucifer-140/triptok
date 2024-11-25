<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Itinerary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TripDuplicateController extends Controller
{
    public function duplicate($trip_id)
    {
        // Find the trip to duplicate
        $originalTrip = Trip::find($trip_id);

        // Check if the trip exists
        if (!$originalTrip) {
            return back()->with('error', 'The trip does not exist.');
        }

        // Begin transaction for data consistency
        DB::beginTransaction();

        try {
            // Duplicate the trip
            $newTrip = $originalTrip->replicate();
            $newTrip->user_id = Auth::id(); // Assign to the current user
            $newTrip->tripTitle .= ' (Copy)'; // Append 'Copy' to the name
            $newTrip->save();

            // Duplicate the status from the TripStatus table
            $originalStatus = $originalTrip->status; // Get the associated status
            if ($originalStatus) {
                $newStatus = $originalStatus->replicate(); // Duplicate the status
                $newStatus->trip_id = $newTrip->id; // Link it to the new trip
                $newStatus->save();
            }

            // Duplicate the itinerary and related data
            $originalItinerary = Itinerary::where('trip_id', $originalTrip->id)->first();
            if ($originalItinerary) {
                $newItinerary = $originalItinerary->replicate();
                $newItinerary->trip_id = $newTrip->id;
                $newItinerary->save();

                foreach ($originalItinerary->days as $originalDay) {
                    $newDay = $originalDay->replicate();
                    $newDay->itinerary_id = $newItinerary->id;
                    $newDay->save();

                    // Duplicate activities, transports, accommodations, flights
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
            }

            // Commit the transaction
            DB::commit();

            return back()->with('success', 'Trip duplicated successfully!');
        } catch (\Exception $e) {
            // Rollback on error
            DB::rollBack();
            \Log::error('Error duplicating trip: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'There was an error duplicating the trip.');
        }
    }

}
