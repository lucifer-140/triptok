<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function create($day)
    {
        return view('accommodation.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in',
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

        return view('accommodation.edit', compact('accommodation', 'day'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d|after_or_equal:check_in',
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
