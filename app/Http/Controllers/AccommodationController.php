<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Accommodation;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccommodationController extends Controller
{
    public function create($day)
    {
        // Fetch the day instance based on the ID
        $day = Day::findOrFail($day);

        // Get the related itinerary
        $itinerary = $day->itinerary;

        // Get the related trip from the itinerary
        $trip = $itinerary ? $itinerary->trip : null;

        // Check if trip exists and parse its start and end dates using Carbon
        if ($trip) {
            // Explicitly parse the start and end dates as Carbon instances
            $startDate = Carbon::parse($trip->tripStartDate);
            $endDate = Carbon::parse($trip->tripEndDate);

            // Debugging to check the start and end dates as Carbon instances
            // dd($startDate, $endDate);

            return view('accommodation.create', [
                'day' => $day,
                'tripStartDate' => $startDate->toDateString(), // Carbon method to format
                'tripEndDate' => $endDate->toDateString(),     // Carbon method to format
            ]);
        }

        // Handle the case where no trip is related to the day (optional)
        return redirect()->route('some.route')->with('error', 'Trip not found for this day.');
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

        // Get the related itinerary from the day
        $itinerary = $day->itinerary;

        // Get the related trip from the itinerary
        $trip = $itinerary ? $itinerary->trip : null;

        // Check if trip exists and parse its start and end dates using Carbon
        if ($trip) {
            // Explicitly parse the start and end dates as Carbon instances
            $startDate = Carbon::parse($trip->tripStartDate);
            $endDate = Carbon::parse($trip->tripEndDate);

            return view('accommodation.edit', [
                'accommodation' => $accommodation,
                'day' => $day,
                'tripStartDate' => $startDate->toDateString(), // Carbon method to format
                'tripEndDate' => $endDate->toDateString(),     // Carbon method to format
            ]);
        }

        // Handle the case where no trip is related to the day (optional)
        return redirect()->route('some.route')->with('error', 'Trip not found for this day.');
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
