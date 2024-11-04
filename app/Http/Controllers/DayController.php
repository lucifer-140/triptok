<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'itinerary_id' => 'required|integer|exists:itineraries,id',
            'day' => 'required|integer',
            'date' => 'required|date',
        ]);

        $day = Day::create([
            'itinerary_id' => $request->itinerary_id,
            'day' => $request->day,
            'date' => $request->date,
        ]);

        // Redirect to the day plan page (day.blade.php)
        return redirect()->route('day.show', ['day' => $day->id])
                         ->with('success', 'Day plan created successfully!');
    }

    public function show($day)
    {
        // Eager load the itinerary and the associated trip
        $day = Day::with('itinerary.trip')->findOrFail($day); // This retrieves the day with the related itinerary and trip
        $itinerary = $day->itinerary; // Get the related itinerary
        $trip = $itinerary ? $itinerary->trip : null; // Get the related trip, if exists

        // Set the currency variable
        $currency = $trip ? $trip->currency : null; // Assign currency to the $currency variable

        return view('trips.day', compact('day', 'itinerary', 'trip', 'currency')); // Pass the currency to the view
    }






}
