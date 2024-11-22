<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            Destination::create([
                'name' => $faker->country, // Generate random country name
                'description' => $faker->sentence(10), // Generate a random sentence
                'image' => $faker->imageUrl(500, 300, 'travel', true, 'Destination'), // Generate a random image URL
                'rating' => $faker->randomFloat(1, 3.0, 5.0), // Generate a random rating between 3.0 and 5.0
            ]);
        }
    }
}
