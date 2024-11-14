<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
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

        // Fetch the related trip title from the Trip model
        $tripTitle = $itinerary->trip->tripTitle;

        // Set the filename as the trip title with safe characters
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $tripTitle) . ".ics";

        // Start ICS content with app-specific identifier
        $icsContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Triptok//EN\r\n";

        // Loop through each day in the itinerary
        foreach ($itinerary->days as $day) {
            $date = Carbon::parse($day->date)->format('Ymd');

            // Add each activity as an event with a Gemini-generated summary
            foreach ($day->activities as $activity) {
                $startTime = Carbon::parse($activity->start_time)->format('His');
                $endTime = Carbon::parse($activity->end_time)->format('His');
                $summary = $this->generateGeminiSummary("Activity", $activity->title);
                $icsContent .= $this->formatEvent($summary, $activity->description, $date, $startTime, $endTime);
            }

            // Add each accommodation check-in/check-out as events
            foreach ($day->accommodations as $accommodation) {
                $checkInTime = Carbon::parse($accommodation->check_in)->format('His');
                $checkOutTime = Carbon::parse($accommodation->check_out)->format('His');
                $checkInSummary = $this->generateGeminiSummary("Accommodation Check-in", $accommodation->name);
                $checkOutSummary = $this->generateGeminiSummary("Accommodation Check-out", $accommodation->name);
                $icsContent .= $this->formatEvent($checkInSummary, '', $date, $checkInTime);
                $icsContent .= $this->formatEvent($checkOutSummary, '', $date, $checkOutTime);
            }

            // Add each flight as an event
            foreach ($day->flights as $flight) {
                $flightDate = Carbon::parse($flight->date)->format('Ymd');
                $departureTime = Carbon::parse($flight->departure_time)->format('His');
                $arrivalTime = Carbon::parse($flight->arrival_time)->format('His');
                $summary = $this->generateGeminiSummary("Flight", $flight->flight_number);
                $icsContent .= $this->formatEvent($summary, '', $flightDate, $departureTime, $arrivalTime);
            }

            // Add each transport as an event
            foreach ($day->transports as $transport) {
                $transportDate = Carbon::parse($transport->date)->format('Ymd');
                $departureTime = Carbon::parse($transport->departure_time)->format('His');
                $arrivalTime = Carbon::parse($transport->arrival_time)->format('His');
                $summary = $this->generateGeminiSummary("Transport", $transport->type);
                $icsContent .= $this->formatEvent($summary, '', $transportDate, $departureTime, $arrivalTime);
            }
        }

        // End calendar
        $icsContent .= "END:VCALENDAR";

        // Using stream for more explicit control over the download process
        return response()->stream(
            function () use ($icsContent) {
                echo $icsContent;
            },
            200,
            [
                'Content-Type' => 'text/calendar',
                'Content-Disposition' => 'attachment; filename="' . urlencode($filename) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]
        );
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

    private function generateGeminiSummary($type, $title)
    {
        // Generate a summary message based on the type of event
        switch ($type) {
            case "Activity":
                return "Upcoming Activity: {$title}";
            case "Accommodation Check-in":
                return "Check-in Reminder: {$title}";
            case "Accommodation Check-out":
                return "Check-out Reminder: {$title}";
            case "Flight":
                return "Flight Alert: {$title}";
            case "Transport":
                return "Transport Alert: {$title}";
            default:
                return "Upcoming Event: {$title}";
        }
    }
}
