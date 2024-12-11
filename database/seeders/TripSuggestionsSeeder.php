<?php

namespace Database\Seeders;

use App\Models\TripSuggestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSuggestionsSeeder extends Seeder
{
    public function run()
    {
        // Load the CSV file
        $csvFile = fopen(storage_path('app/realistic_trip_itineraries.csv'), 'r');
        $header = fgetcsv($csvFile); // Read the header row

        // Read each row of the CSV and insert it into the database
        while ($row = fgetcsv($csvFile)) {
            $data = array_combine($header, $row); // Combine header with row values
            TripSuggestion::create([
                'trip_id' => $data['trip_id'],
                'country' => $data['country'],
                'trip_start_date' => $data['trip_start_date'],
                'trip_end_date' => $data['trip_end_date'],
                'day' => $data['day'],
                'date' => $data['date'],
                'activity_id' => $data['activity_id'],
                'activity_title' => $data['activity_title'],
                'activity_start_time' => $data['activity_start_time'],
                'activity_end_time' => $data['activity_end_time'],
                'activity_budget' => $data['activity_budget'],
                'activity_description' => $data['activity_description'],
                'transport_type' => $data['transport_type'],
                'transport_departure_time' => $data['transport_departure_time'],
                'transport_arrival_time' => $data['transport_arrival_time'],
                'transport_cost' => $data['transport_cost'],
                'accommodation_name' => $data['accommodation_name'],
                'accommodation_check_in' => $data['accommodation_check_in'],
                'accommodation_check_out' => $data['accommodation_check_out'],
                'accommodation_cost' => $data['accommodation_cost'],
            ]);
        }

        fclose($csvFile);
    }
}
