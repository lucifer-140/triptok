<?php

namespace App\Http\Controllers;
use App\Models\Day;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function create($day)
    {
        return view('activities.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'budget' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $validated['day_id'] = $day;

        Activity::create($validated);

        return redirect()->route('day.show', $day)->with('success', 'Activity added successfully.');
    }


    public function edit($activityId)
    {
        // Find the activity by its ID
        $activity = Activity::findOrFail($activityId);

        // Retrieve the associated day (you may need to adjust this based on your relationships)
        $day = Day::findOrFail($activity->day_id);

        return view('activities.edit', compact('activity', 'day'));
    }



    public function update(Request $request, Activity $activity)
    {
        // Prepare validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'budget' => 'required|numeric',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i:s',  // Changed to H:i:s
            'end_time' => 'nullable|date_format:H:i:s',    // Changed to H:i:s
        ];

        // Validate the request
        $validated = $request->validate($rules);

        // Update the activity with validated data
        $activity->update(array_merge($validated, [
            'start_time' => $request->input('start_time', $activity->start_time),
            'end_time' => $request->input('end_time', $activity->end_time),
        ]));

        // Redirect to the day view with success message
        return redirect()->route('day.show', $activity->day_id)->with('success', 'Activity updated successfully!');
    }



    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->route('day.show', $activity->day_id)->with('success', 'Activity deleted successfully.');
    }
}
