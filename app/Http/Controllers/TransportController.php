<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function create($day)
    {
        $day = Day::findOrFail($day);
        return view('transport.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d', // Add this line for date validation
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'cost' => 'required|numeric',
        ]);


        $validated['day_id'] = $day;

        Transport::create($validated);

        return redirect()->route('day.show', $day)->with('success', 'Transport added successfully.');
    }

    public function edit($transportId)
    {
        $transport = Transport::findOrFail($transportId);
        $day = Day::findOrFail($transport->day_id);

        return view('transport.edit', compact('transport', 'day'));
    }

    public function update(Request $request, Transport $transport)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d', // Validates date format (YYYY-MM-DD)
            'departure_time' => 'required|date_format:H:i', // Validates time format (HH:MM)
            'arrival_time' => 'required|date_format:H:i|after:departure_time', // Arrival must be after departure time
            'cost' => 'required|numeric', // Validates cost as a numeric value
        ]);

        // Convert times to 24-hour format using Carbon
        $validated['departure_time'] = Carbon::createFromFormat('H:i', $validated['departure_time'])->format('H:i');
        $validated['arrival_time'] = Carbon::createFromFormat('H:i', $validated['arrival_time'])->format('H:i');

        // Update the transport record with validated data
        $transport->update($validated);

        // Redirect with success message
        return redirect()->route('day.show', $transport->day_id)->with('success', 'Transport updated successfully!');
    }


    public function destroy($id)
    {
        $transport = Transport::findOrFail($id);
        $transport->delete();
        return redirect()->route('day.show', $transport->day_id)->with('success', 'Transport deleted successfully.');
    }
}
