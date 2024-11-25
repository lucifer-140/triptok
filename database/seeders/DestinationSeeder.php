<?php


namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        // Array of destinations
        $destinations = [
            [
                'name' => 'France',
                'description' => 'Known for its beautiful landscapes, world-class museums, and iconic landmarks such as the Eiffel Tower.',
                'image' => 'assets/country/france.jpg', // Image path in public/assets/country/
                'rating' => 4.8,
            ],
            [
                'name' => 'Japan',
                'description' => 'A unique blend of traditional culture and cutting-edge technology, Japan offers beautiful temples, gardens, and modern cities.',
                'image' => 'assets/country/japan.jpg', // Image path in public/assets/country/
                'rating' => 4.7,
            ],
            [
                'name' => 'Brazil',
                'description' => 'Home to the Amazon Rainforest and vibrant cities like Rio de Janeiro, Brazil is famous for its beaches and carnivals.',
                'image' => 'assets/country/brazil.jpg', // Image path in public/assets/country/
                'rating' => 4.6,
            ],
            [
                'name' => 'Italy',
                'description' => 'With its rich history, art, and cuisine, Italy is famous for its landmarks like the Colosseum, Venice canals, and delicious pizza.',
                'image' => 'assets/country/italy.jpg', // Image path in public/assets/country/
                'rating' => 4.9,
            ],
            [
                'name' => 'Australia',
                'description' => 'Known for its stunning landscapes including the Great Barrier Reef, Sydney Opera House, and vast outback.',
                'image' => 'assets/country/australia.jpg', // Image path in public/assets/country/
                'rating' => 4.7,
            ],
            [
                'name' => 'Egypt',
                'description' => 'A historical treasure trove, Egypt is famous for its pyramids, ancient temples, and the Sphinx.',
                'image' => 'assets/country/egypt.jpg', // Image path in public/assets/country/
                'rating' => 4.5,
            ],
            [
                'name' => 'Mexico',
                'description' => 'With rich cultural heritage and beautiful beaches, Mexico offers amazing food, art, and landmarks like Chichen Itza.',
                'image' => 'assets/country/mexico.jpg', // Image path in public/assets/country/
                'rating' => 4.6,
            ],
            [
                'name' => 'South Africa',
                'description' => 'From safaris to beautiful coastlines, South Africa is a destination full of diverse landscapes and wildlife.',
                'image' => 'assets/country/south_africa.jpg', // Image path in public/assets/country/
                'rating' => 4.4,
            ],
            [
                'name' => 'United Kingdom',
                'description' => 'The UK is rich in history, from the Tower of London to Buckingham Palace and the countryside of Scotland and Wales.',
                'image' => 'assets/country/uk.jpg', // Image path in public/assets/country/
                'rating' => 4.7,
            ],
            [
                'name' => 'Canada',
                'description' => 'Known for its natural beauty, Canada boasts stunning national parks, the Rocky Mountains, and multicultural cities like Toronto.',
                'image' => 'assets/country/canada.jpg', // Image path in public/assets/country/
                'rating' => 4.8,
            ],
        ];

        // Loop through each destination and create it in the database
        foreach ($destinations as $destination) {
            Destination::create([
                'name' => $destination['name'],
                'description' => $destination['description'],
                'image' => $destination['image'],
                'rating' => $destination['rating'],
            ]);
        }
    }
}
