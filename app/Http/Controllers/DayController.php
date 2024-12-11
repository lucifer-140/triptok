<?php
namespace App\Http\Controllers;

use App\Models\Day;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id',
            'day' => 'required|integer',
            'date' => 'required|date',
        ]);


        $day = Day::where('itinerary_id', $request->itinerary_id)
                    ->where('day', $request->day)
                    ->first();

        if ($day) {

            $day->update([
                'date' => $request->date,
            ]);
            return redirect()->route('day.show', ['day' => $day->id])
                            ->with('success', 'Day updated successfully!');
        } else {

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

        $day = Day::with(['itinerary.trip', 'activities', 'accommodations', 'flights', 'transports'])
                    ->findOrFail($dayId);

        $itinerary = $day->itinerary;
        $trip = $itinerary ? $itinerary->trip : null;
        $currency = $trip ? $trip->currency : null;


        $activities = $day->activities;
        $accommodations = $day->accommodations;
        $flights = $day->flights;
        $transports = $day->transports;


        $activityTotal = $activities->sum('budget');
        $accommodationTotal = $accommodations->sum('cost');
        $flightTotal = $flights->sum('cost');
        $transportTotal = $transports->sum('cost');

        $grandTotal = $activityTotal + $accommodationTotal + $flightTotal + $transportTotal;


        $day->grand_total = $grandTotal;
        $day->save();


        $startDate = Carbon::parse($trip->tripStartDate);
        $endDate = Carbon::parse($trip->tripEndDate);


        return view('trips.day', compact('day', 'itinerary', 'trip', 'currency', 'activities', 'accommodations', 'flights', 'transports', 'grandTotal', 'startDate', 'endDate'));
    }




}
