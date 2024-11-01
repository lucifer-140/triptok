<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function create()
    {
        $currencies = Currency::all();
        return view('trips.create-trip', compact('currencies'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'tripTitle' => 'required|string|max:255',
            'tripDestination' => 'required|string|max:255',
            'tripStartDate' => 'required|date',
            'tripEndDate' => 'required|date|after_or_equal:tripStartDate',
            'totalBudget' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        // Create a new trip instance and save it to the database
        $trip = new Trip();
        $trip->tripTitle = $request->tripTitle;
        $trip->tripDestination = $request->tripDestination;
        $trip->tripStartDate = $request->tripStartDate;
        $trip->tripEndDate = $request->tripEndDate;
        $trip->totalBudget = $request->totalBudget;
        $trip->currency = $request->currency;
        $trip->user_id = Auth::id(); // Associate the trip with the authenticated user
        $trip->save();

        // Redirect to the itinerary creation page with the trip ID
        return redirect()->route('itinerary.create', ['trip' => $trip->id])
                        ->with('success', 'Trip created successfully!');
    }




    public function index()
    {
        // Get trips that belong to the authenticated user
        $trips = Trip::where('user_id', Auth::id())->get();
        return view('trips.list', compact('trips'));
    }

    public function show($id)
    {
        // Attempt to find the trip by ID and check if it belongs to the authenticated user
        $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('trips.details', compact('trip'));
    }



}
