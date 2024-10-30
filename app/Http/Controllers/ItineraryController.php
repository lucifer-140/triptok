<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function create(Request $request)
    {
        $tripId = $request->input('trip_id');
        return view('trips.itinerary', compact('tripId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id', // Ensure the trip exists
        ]);

        // Create a new itinerary
        $itinerary = Itinerary::create([
            'trip_id' => $request->trip_id,
        ]);

        return redirect()->route('itinerary.show', $itinerary->id)->with('success', 'Itinerary created successfully!');
    }

    public function show($id)
    {
        $itinerary = Itinerary::with('days')->findOrFail($id);
        return view('itineraries.show', compact('itinerary'));
    }
}
