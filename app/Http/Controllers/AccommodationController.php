<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function create($day)
    {
        // Fetch the day instance based on the ID
        $day = Day::findOrFail($day);
        return view('accommodation.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        // Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in', // Ensure check_out is after check_in
            'check_out_time' => 'required|date_format:H:i',
            'cost' => 'required|numeric',
        ]);

        // Store the accommodation with the validated data
        $validated['day_id'] = $day;
        Accommodation::create($validated);

        return redirect()->route('day.show', $day)->with('success', 'Accommodation added successfully.');
    }



    public function edit($accommodationId)
    {
        // Retrieve accommodation and associated day
        $accommodation = Accommodation::findOrFail($accommodationId);
        $day = Day::findOrFail($accommodation->day_id);

        return view('accommodation.edit', compact('accommodation', 'day'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        // Add validation for the new check_out_time field
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in', // Validate check-out date
            'check_out_time' => 'required|date_format:H:i', // Validate check-out time
            'cost' => 'required|numeric',
        ]);

        // Update the accommodation with the validated data
        $accommodation->update($validated);

        return redirect()->route('day.show', $accommodation->day_id)->with('success', 'Accommodation updated successfully!');
    }


    public function destroy($id)
    {
        // Delete the accommodation and return to the day view
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return redirect()->route('day.show', $accommodation->day_id)->with('success', 'Accommodation deleted successfully.');
    }
}
