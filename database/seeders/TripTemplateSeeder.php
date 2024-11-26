<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Destination;


class TripTemplateSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        // Fetch all existing destination IDs
        $destinationIds = Destination::pluck('id')->toArray();

        // Ensure we have destinations before creating templates
        if (empty($destinationIds)) {
            $this->command->info('No destinations found. Please seed destinations first.');
            return;
        }

        // Generate sample trip templates
        for ($i = 0; $i < 30; $i++) {
            DB::table('trip_templates')->insert([
                'destination_id' => $faker->randomElement($destinationIds),
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'duration' => $faker->numberBetween(3, 14), // Duration in days
                'price' => $faker->randomFloat(2, 100, 1000), // Random price
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
