<?php

namespace App\Http\Controllers;
use App\Models\Day;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

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


        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);

        if ($endTime <= $startTime) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }


        $validated['day_id'] = $day;


        Activity::create($validated);


        return redirect()->route('day.show', $day)->with('success', 'Activity added successfully.');
    }

    public function edit($activityId)
    {

        $activity = Activity::findOrFail($activityId);


        $day = Day::findOrFail($activity->day_id);

        return view('activities.edit', compact('activity', 'day'));
    }

    public function update(Request $request, Activity $activity)
    {

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');


        $startTime = $this->convertTo24HourFormat($startTime);
        $endTime = $this->convertTo24HourFormat($endTime);


        $rules = [
            'title' => 'required|string|max:255',
            'budget' => 'required|numeric',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];


        $validated = $request->validate($rules);


        $startTimeCarbon = Carbon::createFromFormat('H:i', $startTime);
        $endTimeCarbon = Carbon::createFromFormat('H:i', $endTime);

        if ($endTimeCarbon <= $startTimeCarbon) {
            return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
        }


        $activity->update(array_merge($validated, [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]));


        return redirect()->route('day.show', $activity->day_id)->with('success', 'Activity updated successfully!');
    }


    private function convertTo24HourFormat($timeString)
    {
        $timeString = trim($timeString);


        \Log::debug('Raw Time String (Trimmed): ' . $timeString);


        if (strpos($timeString, ':') !== false && strpos($timeString, ':00') !== false) {

            $timeString = preg_replace('/:[0-9]{2}$/', '', $timeString);
        }


        \Log::debug('Time String after removing seconds (if applicable): ' . $timeString);

        try {

            if (strpos($timeString, 'AM') !== false || strpos($timeString, 'PM') !== false) {

                $time = Carbon::createFromFormat('h:i A', $timeString);
            } else {

                $time = Carbon::createFromFormat('H:i', $timeString);
            }


            return $time->format('H:i');
        } catch (\Exception $e) {

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
