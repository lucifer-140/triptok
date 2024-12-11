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

        $originalTrip = Trip::find($trip_id);


        if (!$originalTrip) {
            return back()->with('error', 'The trip does not exist.');
        }


        DB::beginTransaction();

        try {

            $newTrip = $originalTrip->replicate();
            $newTrip->user_id = Auth::id();
            $newTrip->tripTitle .= ' (Copy)';
            $newTrip->save();


            $originalStatus = $originalTrip->status;
            if ($originalStatus) {
                $newStatus = $originalStatus->replicate();
                $newStatus->trip_id = $newTrip->id;
                $newStatus->save();
            }


            $originalItinerary = Itinerary::where('trip_id', $originalTrip->id)->first();
            if ($originalItinerary) {
                $newItinerary = $originalItinerary->replicate();
                $newItinerary->trip_id = $newTrip->id;
                $newItinerary->save();

                foreach ($originalItinerary->days as $originalDay) {
                    $newDay = $originalDay->replicate();
                    $newDay->itinerary_id = $newItinerary->id;
                    $newDay->save();


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


            DB::commit();

            return back()->with('success', 'Trip duplicated successfully!');
        } catch (\Exception $e) {

            DB::rollBack();
            \Log::error('Error duplicating trip: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'There was an error duplicating the trip.');
        }
    }

}
