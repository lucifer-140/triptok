<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the TripSuggestionsSeeder to populate the trip_suggestions table
        $this->call(TripSuggestionsSeeder::class);
    }
}
