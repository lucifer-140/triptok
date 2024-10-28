<?php

namespace App\Http\Controllers;

use App\Models\Trip; // Make sure your Trip model is imported
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function show($id)
    {
        // Fetch the trip details from the database
        $trip = Trip::find($id);

        // Check if the trip exists
        if (!$trip) {
            return redirect()->route('trips.index')->with('error', 'Trip not found.');
        }

        // Pass the trip data to the itinerary view
        return view('trips.itinerary', ['trip' => $trip]);
    }
}
