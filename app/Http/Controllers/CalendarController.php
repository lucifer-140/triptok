<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Day;
use App\Models\Activity;
use App\Models\Accommodation;
use App\Models\Flight;
use App\Models\Transport;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function downloadICS($itineraryId)
    {
        // Fetch the itinerary along with days and associated data
        $itinerary = Itinerary::with([
            'days.activities',
            'days.accommodations',
            'days.flights',
            'days.transports',
        ])->findOrFail($itineraryId);

        // Create ICS content
        $icsContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//YourApp//EN\r\n";

        // Loop through each day in the itinerary
        foreach ($itinerary->days as $day) {
            // Format day date
            $date = Carbon::parse($day->date)->format('Ymd');

            // Add each activity as an event
            foreach ($day->activities as $activity) {
                $startTime = Carbon::parse($activity->start_time)->format('His');
                $endTime = Carbon::parse($activity->end_time)->format('His');
                $icsContent .= $this->formatEvent("Activity: {$activity->title}", $activity->description, $date, $startTime, $endTime);
            }

            // Add each accommodation check-in/check-out as events
            foreach ($day->accommodations as $accommodation) {
                $checkInTime = Carbon::parse($accommodation->check_in)->format('His');
                $checkOutTime = Carbon::parse($accommodation->check_out)->format('His');
                $icsContent .= $this->formatEvent("Accommodation: {$accommodation->name} - Check-in", '', $date, $checkInTime);
                $icsContent .= $this->formatEvent("Accommodation: {$accommodation->name} - Check-out", '', $date, $checkOutTime);
            }

            // Add each flight as an event
            foreach ($day->flights as $flight) {
                $flightDate = Carbon::parse($flight->date)->format('Ymd');
                $departureTime = Carbon::parse($flight->departure_time)->format('His');
                $arrivalTime = Carbon::parse($flight->arrival_time)->format('His');
                $icsContent .= $this->formatEvent("Flight: {$flight->flight_number}", '', $flightDate, $departureTime, $arrivalTime);
            }

            // Add each transport as an event
            foreach ($day->transports as $transport) {
                $transportDate = Carbon::parse($transport->date)->format('Ymd');
                $departureTime = Carbon::parse($transport->departure_time)->format('His');
                $arrivalTime = Carbon::parse($transport->arrival_time)->format('His');
                $icsContent .= $this->formatEvent("Transport: {$transport->type}", '', $transportDate, $departureTime, $arrivalTime);
            }
        }

        // End calendar
        $icsContent .= "END:VCALENDAR";

        // Return ICS file as download
        return Response::make($icsContent, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="itinerary.ics"',
        ]);
    }

    private function formatEvent($summary, $description, $date, $startTime, $endTime = null)
    {
        $event = "BEGIN:VEVENT\r\n";
        $event .= "SUMMARY:{$summary}\r\n";
        $event .= "DESCRIPTION:{$description}\r\n";
        $event .= "DTSTART:{$date}T{$startTime}Z\r\n";
        if ($endTime) {
            $event .= "DTEND:{$date}T{$endTime}Z\r\n";
        }
        $event .= "END:VEVENT\r\n";

        return $event;
    }
}
