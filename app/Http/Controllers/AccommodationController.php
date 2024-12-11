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

        $day = Day::findOrFail($day);

        
        $itinerary = $day->itinerary;


        $trip = $itinerary ? $itinerary->trip : null;


        if ($trip) {

            $startDate = Carbon::parse($trip->tripStartDate);
            $endDate = Carbon::parse($trip->tripEndDate);




            return view('accommodation.create', [
                'day' => $day,
                'tripStartDate' => $startDate->toDateString(),
                'tripEndDate' => $endDate->toDateString(),
            ]);
        }


        return redirect()->route('some.route')->with('error', 'Trip not found for this day.');
    }



    public function store(Request $request, $day)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in',
            'check_out_time' => 'required|date_format:H:i',
            'cost' => 'required|numeric',
        ]);


        $validated['day_id'] = $day;
        Accommodation::create($validated);

        return redirect()->route('day.show', $day)->with('success', 'Accommodation added successfully.');
    }

    public function edit($accommodationId)
    {

        $accommodation = Accommodation::findOrFail($accommodationId);
        $day = Day::findOrFail($accommodation->day_id);


        $itinerary = $day->itinerary;


        $trip = $itinerary ? $itinerary->trip : null;


        if ($trip) {

            $startDate = Carbon::parse($trip->tripStartDate);
            $endDate = Carbon::parse($trip->tripEndDate);

            return view('accommodation.edit', [
                'accommodation' => $accommodation,
                'day' => $day,
                'tripStartDate' => $startDate->toDateString(),
                'tripEndDate' => $endDate->toDateString(),
            ]);
        }


        return redirect()->route('some.route')->with('error', 'Trip not found for this day.');
    }

    public function update(Request $request, Accommodation $accommodation)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in',
            'check_out_time' => 'required|date_format:H:i',
            'cost' => 'required|numeric',
        ]);


        $accommodation->update($validated);

        return redirect()->route('day.show', $accommodation->day_id)->with('success', 'Accommodation updated successfully!');
    }

    public function destroy($id)
    {

        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return redirect()->route('day.show', $accommodation->day_id)->with('success', 'Accommodation deleted successfully.');
    }
}
