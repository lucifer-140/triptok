<?php

// app/Http/Controllers/TravelController.php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    // Function to return the travel guide page with dynamic data
    public function index(Request $request)
    {
        // Initialize query for fetching destinations
        $query = Destination::query();

        // Check if there's a search term and filter by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get the paginated destinations
        $destinations = $query->paginate(9);

        // Return the view with the destinations
        return view('travel.travel-guide', compact('destinations'));
    }

    public function show($id)
    {
        // Fetch the destination by ID
        $destination = Destination::findOrFail($id);  // Find by ID

        // Return the destination detail view with the data
        return view('travel.destination-detail', compact('destination'));
    }
}
