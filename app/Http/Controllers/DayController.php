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

    public function show($day)
    {
        // Eager load the itinerary and the associated trip
        $day = Day::with('itinerary.trip')->findOrFail($day); // Retrieve the day with related itinerary and trip
        $itinerary = $day->itinerary; // Get the related itinerary
        $trip = $itinerary ? $itinerary->trip : null; // Get the related trip, if exists
        $currency = $trip ? $trip->currency : null; // Assign currency to the $currency variable

        return view('trips.day', compact('day', 'itinerary', 'trip', 'currency')); // Pass the variables to the view
    }
}
