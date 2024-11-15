<?php

namespace App\Http\Controllers;

use App\Models\SharedTrip;
use Illuminate\Http\Request;
use App\Http\Controllers\TripShareController;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $receivedRequests = $user->receivedRequests()->where('status', 'pending')->get();

        // Fetch notifications (shared trips that are pending)
        $sharedTrips = SharedTrip::where('user_id', auth()->id())
                                  ->where('status', 'pending')
                                  ->get();


        return view('notifications.index', compact('sharedTrips', 'receivedRequests'));
    }

    public function updateNotifications()
    {
        $user = auth()->user();

        // Debugging: Log counts
        $receivedRequestsCount = $user->receivedRequests()->where('status', 'pending')->count();
        $sharedTripsCount = SharedTrip::where('user_id', auth()->id())->where('status', 'pending')->count();

        \Log::info('Received Requests Count: ' . $receivedRequestsCount);
        \Log::info('Shared Trips Count: ' . $sharedTripsCount);

        $user->update(['notification_count' => $receivedRequestsCount + $sharedTripsCount]);

        return response()->json(['message' => 'Notification count updated.']);
    }



    // Accept or Reject shared trip notification
    public function accept($id)
    {
        $tripShareController = new TripShareController();
        return $tripShareController->accept($id);
    }

    public function reject($id)
    {
        $tripShareController = new TripShareController();
        return $tripShareController->reject($id);
    }
}
