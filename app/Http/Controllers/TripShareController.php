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

        return back()->with('message', 'Trip shared successfully!');
    }

    public function accept($id)
    {
        try {
            $sharedTrip = SharedTrip::findOrFail($id);

            // Check if the user is the receiver of the shared trip
            if ($sharedTrip->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Update the shared trip status to accepted
            $sharedTrip->status = 'accepted';
            $sharedTrip->save();

            return redirect()->route('notifications.index')->with('success', 'Trip invitation accepted.');

        } catch (\Exception $e) {
            \Log::error('Error accepting shared trip: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error processing your request. Please try again.');
        }
    }

    public function reject($id)
    {
        try {
            $sharedTrip = SharedTrip::findOrFail($id);

            // Check if the user is the receiver of the shared trip
            if ($sharedTrip->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Update the shared trip status to rejected
            $sharedTrip->status = 'rejected';
            $sharedTrip->save();

            return redirect()->route('notifications.index')->with('success', 'Trip invitation rejected.');

        } catch (\Exception $e) {
            \Log::error('Error rejecting shared trip: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error processing your request. Please try again.');
        }
    }


    // public function notifications()
    // {
    //     // Fetch all the shared trips where the user is the receiver
    //     $sharedTrips = SharedTrip::where('user_id', auth()->id())
    //                             ->where('status', 'pending')
    //                             ->get();

    //     return view('notifications', compact('sharedTrips'));
    // }


}
