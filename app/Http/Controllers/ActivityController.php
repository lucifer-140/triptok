<?php

namespace App\Http\Controllers;
use App\Models\Day;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon; // Add Carbon for time comparison

class ActivityController extends Controller
{
    public function create($day)
    {
        return view('activities.create', compact('day'));
    }

    public function store(Request $request, $day)
    {
        // Custom validation for start time and end time comparison
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'budget' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Compare start and end times
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);

        if ($endTime <= $startTime) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }

        // Add the day ID to the validated data
        $validated['day_id'] = $day;

        // Create the activity
        Activity::create($validated);

        // Redirect with success message
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
        // Convert the 12-hour format to 24-hour format if necessary
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        // Check if the input is in 12-hour format, and convert to 24-hour format
        $startTime = $this->convertTo24HourFormat($startTime);
        $endTime = $this->convertTo24HourFormat($endTime);

        // Custom validation for start time and end time comparison
        $rules = [
            'title' => 'required|string|max:255',
            'budget' => 'required|numeric',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i', // Ensures start time is required and matches the H:i format
            'end_time' => 'required|date_format:H:i|after:start_time', // Ensures end time is after start time and matches the H:i format
        ];

        // Validate the request
        $validated = $request->validate($rules);

        // Compare start and end times if provided
        $startTimeCarbon = Carbon::createFromFormat('H:i', $startTime);
        $endTimeCarbon = Carbon::createFromFormat('H:i', $endTime);

        if ($endTimeCarbon <= $startTimeCarbon) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }

        // Update the activity with validated data
        $activity->update(array_merge($validated, [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]));

        // Redirect to the day view with success message
        return redirect()->route('day.show', $activity->day_id)->with('success', 'Activity updated successfully!');
    }

    // Helper function to convert 12-hour AM/PM time to 24-hour H:i format
    private function convertTo24HourFormat($timeString)
    {
        $timeString = trim($timeString); // Remove any leading or trailing spaces

        // Debug: Log the raw time string before manipulation
        \Log::debug('Raw Time String (Trimmed): ' . $timeString); // Log or use dd($timeString); for debugging

        // Remove seconds if present (e.g., "11:02:00" becomes "11:02")
        if (strpos($timeString, ':') !== false && strpos($timeString, ':00') !== false) {
            // Only remove seconds if they're explicitly present
            $timeString = preg_replace('/:[0-9]{2}$/', '', $timeString); // Remove seconds part if :00
        }

        // Debug: Log the time string after removing seconds
        \Log::debug('Time String after removing seconds (if applicable): ' . $timeString);

        try {
            // Try parsing time string with AM/PM first
            if (strpos($timeString, 'AM') !== false || strpos($timeString, 'PM') !== false) {
                // If AM/PM is present, parse as 12-hour format and convert to 24-hour format
                $time = Carbon::createFromFormat('h:i A', $timeString);
            } else {
                // If AM/PM is not present, assume 24-hour format
                $time = Carbon::createFromFormat('H:i', $timeString);
            }

            // Return the time in 24-hour format
            return $time->format('H:i');
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Error parsing time with Carbon: ' . $e->getMessage());
            throw new \InvalidArgumentException('The provided time format is invalid. Please use "H:i" format.');
        }
    }




    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->route('day.show', $activity->day_id)->with('success', 'Activity deleted successfully.');
    }
}
