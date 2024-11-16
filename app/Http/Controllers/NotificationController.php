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
