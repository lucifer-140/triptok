<?php
namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id', // Validate that the itinerary_id exists
            'day' => 'required|integer', // Ensure day is an integer
            'date' => 'required|date', // Ensure date is a valid date
        ]);

        // Check if the day already exists for the given itinerary
        $day = Day::where('itinerary_id', $request->itinerary_id)
                  ->where('day', $request->day)
                  ->first();

        if ($day) {
            // If the day exists, update it
            $day->update([
                'date' => $request->date, // Update the date or any other fields as needed
            ]);
            return redirect()->route('day.show', ['day' => $day->id])
                             ->with('success', 'Day updated successfully!');
        } else {
            // If the day does not exist, create a new entry
            $day = Day::create([
                'itinerary_id' => $request->itinerary_id,
                'day' => $request->day,
                'date' => $request->date,
            ]);
            return redirect()->route('day.show', ['day' => $day->id])
                             ->with('success', 'Day created successfully!');
        }
    }

    public function show($dayId)
    {
        // Eager load the day with related itinerary, trip, and other related items
        $day = Day::with(['itinerary.trip', 'activities', 'accommodations', 'flights', 'transports'])
                   ->findOrFail($dayId); // Retrieve the day with related data

        $itinerary = $day->itinerary; // Get the related itinerary
        $trip = $itinerary ? $itinerary->trip : null; // Get the related trip, if exists
        $currency = $trip ? $trip->currency : null; // Assign currency to the $currency variable

        // Retrieve related data directly from the $day object
        $activities = $day->activities;
        $accommodations = $day->accommodations;
        $flights = $day->flights;
        $transports = $day->transports;

        // Calculate totals
        $activityTotal = $activities->sum('budget');
        $accommodationTotal = $accommodations->sum('cost');
        $flightTotal = $flights->sum('cost');
        $transportTotal = $transports->sum('cost');

        $grandTotal = $activityTotal + $accommodationTotal + $flightTotal + $transportTotal;

        // Save the grand total to the database
        $day->grand_total = $grandTotal;
        $day->save();

        // Pass the variables to the view
        return view('trips.day', compact('day', 'itinerary', 'trip', 'currency', 'activities', 'accommodations', 'flights', 'transports', 'grandTotal'));
    }



}
