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
                $startReminderTime = Carbon::parse($activity->start_time)->subMinutes(30)->format('His');
                $endReminderTime = Carbon::parse($activity->end_time)->subMinutes(30)->format('His');

                $summary = $this->generateGeminiSummary("Activity", $activity->title);
                $icsContent .= $this->formatEvent(
                    $summary,
                    $activity->description,
                    $date,
                    $startTime,
                    $endTime
                );

                // Reminder 30 minutes before the start time
                $startReminderSummary = $this->generateGeminiSummary("Reminder", "Activity Reminder: {$activity->title} (Start)");
                $icsContent .= $this->formatEvent(
                    $startReminderSummary,
                    "Reminder: Your activity '{$activity->title}' starts in 30 minutes.",
                    $date,
                    $startReminderTime
                );

                // Reminder 30 minutes before the end time
                $endReminderSummary = $this->generateGeminiSummary("Reminder", "Activity Reminder: {$activity->title} (End)");
                $icsContent .= $this->formatEvent(
                    $endReminderSummary,
                    "Reminder: Your activity '{$activity->title}' ends in 30 minutes.",
                    $date,
                    $endReminderTime
                );
            }

            foreach ($day->accommodations as $accommodation) {
                $checkInDate = Carbon::parse($accommodation->check_in)->format('Ymd');
                $checkInTime = "130000"; // Fixed check-in time: 1 PM local time
                $checkOutDate = Carbon::parse($accommodation->check_out)->format('Ymd');
                $checkOutTime = Carbon::parse($accommodation->check_out_time)->format('His');

                // Check-in reminder
                $checkInSummary = $this->generateGeminiSummary("Accommodation Check-in", $accommodation->name);
                $icsContent .= $this->formatEvent(
                    $checkInSummary,
                    "Check-in for accommodation at {$accommodation->name}.",
                    $checkInDate,
                    $checkInTime
                );

                // Check-out reminder
                $checkOutSummary = $this->generateGeminiSummary("Accommodation Check-out", $accommodation->name);
                $icsContent .= $this->formatEvent(
                    $checkOutSummary,
                    "Check-out from accommodation at {$accommodation->name}.",
                    $checkOutDate,
                    $checkOutTime
                );

                // Reminder 1 hour before check-out
                $reminderTime = Carbon::parse($accommodation->check_out_time)->subHour()->format('His');
                $reminderSummary = $this->generateGeminiSummary("Reminder", "Check-out Reminder: {$accommodation->name}");
                $icsContent .= $this->formatEvent(
                    $reminderSummary,
                    "Reminder: Check-out from accommodation at {$accommodation->name} is in 1 hour.",
                    $checkOutDate,
                    $reminderTime
                );
            }

            // Add each flight as an event
            foreach ($day->flights as $flight) {
                $flightDate = Carbon::parse($flight->date)->format('Ymd');
                $departureTime = Carbon::parse($flight->departure_time)->format('His');
                $arrivalTime = Carbon::parse($flight->arrival_time)->format('His');
                $reminderTime = Carbon::parse($flight->departure_time)->subHour()->format('His');

                $summary = $this->generateGeminiSummary("Flight", $flight->flight_number);
                $icsContent .= $this->formatEvent(
                    $summary,
                    "Flight {$flight->flight_number} from {$flight->departure_airport} to {$flight->arrival_airport}.",
                    $flightDate,
                    $departureTime,
                    $arrivalTime
                );

                // Reminder 1 hour before departure
                $reminderSummary = $this->generateGeminiSummary("Reminder", "Flight Reminder: {$flight->flight_number}");
                $icsContent .= $this->formatEvent(
                    $reminderSummary,
                    "Reminder: Your flight {$flight->flight_number} departs in 1 hour.",
                    $flightDate,
                    $reminderTime
                );
            }

            // Add each transport as an event
            foreach ($day->transports as $transport) {
                $transportDate = Carbon::parse($transport->date)->format('Ymd');
                $departureTime = Carbon::parse($transport->departure_time)->format('His');
                $arrivalTime = Carbon::parse($transport->arrival_time)->format('His');
                $reminderTime = Carbon::parse($transport->departure_time)->subHour()->format('His');

                $summary = $this->generateGeminiSummary("Transport", $transport->type);
                $icsContent .= $this->formatEvent(
                    $summary,
                    "Transport ({$transport->type}) from {$transport->departure_location} to {$transport->arrival_location}.",
                    $transportDate,
                    $departureTime,
                    $arrivalTime
                );

                // Reminder 1 hour before departure
                $reminderSummary = $this->generateGeminiSummary("Reminder", "Transport Reminder: {$transport->type}");
                $icsContent .= $this->formatEvent(
                    $reminderSummary,
                    "Reminder: Your transport ({$transport->type}) departs in 1 hour.",
                    $transportDate,
                    $reminderTime
                );
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
        $event .= "DTSTART:{$date}T{$startTime}\r\n";
        if ($endTime) {
            $event .= "DTEND:{$date}T{$endTime}\r\n";
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
