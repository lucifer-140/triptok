<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip; // Import the Trip model
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Store method called');

        // Validate the request
        $request->validate([
            'tripTitle' => 'required|string|max:100',
            'tripDestination' => 'required|string|max:100',
            'tripStartDate' => 'required|date',
            'tripEndDate' => 'required|date|after_or_equal:tripStartDate',
            'totalBudget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
        ]);

        // Calculate total days
        $totalDays = (new \DateTime($request->tripEndDate))->diff(new \DateTime($request->tripStartDate))->days + 1; // Add 1 to include the start date

        // Create a new trip
        $trip = Trip::create([
            'user_id' => Auth::id(),
            'trip_title' => $request->tripTitle,
            'destination' => $request->tripDestination,
            'start_date' => $request->tripStartDate,
            'end_date' => $request->tripEndDate,
            'total_budget' => $request->totalBudget,
            'currency' => $request->currency,
            'total_days' => $totalDays, // Store total days
        ]);

        \Log::info('Trip created: ', $trip->toArray());

        // Flash success message
        session()->flash('success', 'Trip created successfully!');

        // Redirect to the itinerary page with trip data
        return redirect()->route('itinerary', [
            'tripId' => $trip->id,
        ]);
    }

    public function showItinerary($tripId)
    {
        $trip = Trip::with('itineraries')->findOrFail($tripId); // Load trip and related itineraries
        return view('itinerary', compact('trip'));
    }


}
