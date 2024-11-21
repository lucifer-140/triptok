<?php

// app/Http/Controllers/TravelController.php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        // Example static data (list of cities)
        $cities = [
            'paris', 'tokyo', 'sydney', 'new-york', 'london',
            'rome', 'dubai', 'barcelona', 'madrid', 'bangkok'
        ];

        // Current page from the request (defaults to 1 if not set)
        $currentPage = request()->get('page', 1);

        // Items per page
        $perPage = 9;

        // Slice the array to only get items for the current page
        $currentItems = array_slice($cities, ($currentPage - 1) * $perPage, $perPage);

        // Create the paginator instance
        $destinations = new LengthAwarePaginator(
            $currentItems,       // Items for the current page
            count($cities),      // Total number of items
            $perPage,            // Items per page
            $currentPage,        // Current page
            ['path' => request()->url()] // Path for pagination links
        );

        // Pass the paginator to the view
        return view('travel.travel-guide', compact('destinations'));
    }
}
