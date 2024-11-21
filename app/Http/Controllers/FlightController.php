<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Http\Request;


class FlightController extends Controller
{
    public function create($day)
    {
        $day = Day::findOrFail($day);
        return view('flights.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:255',
            'date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'cost' => 'required|numeric',
        ]);

        $validated['day_id'] = $day;

        Flight::create($validated); // This should work if all fields are provided

        return redirect()->route('day.show', $day)->with('success', 'Flight added successfully.');
    }



    public function edit($flightId)
    {
        $flight = Flight::findOrFail($flightId);
        $day = Day::findOrFail($flight->day_id);

        return view('flights.edit', compact('flight', 'day'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:255',
            'date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'cost' => 'required|numeric',
        ]);

        // Convert times to 24-hour format using Carbon
        $validated['departure_time'] = Carbon::createFromFormat('H:i', $validated['departure_time'])->format('H:i');
        $validated['arrival_time'] = Carbon::createFromFormat('H:i', $validated['arrival_time'])->format('H:i');

        $flight->update($validated);

        return redirect()->route('day.show', $flight->day_id)->with('success', 'Flight updated successfully!');
    }

    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();
        return redirect()->route('day.show', $flight->day_id)->with('success', 'Flight deleted successfully.');
    }
}
