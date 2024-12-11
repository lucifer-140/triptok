<?php



namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TripSuggestion;
use Illuminate\Http\Request;

class TravelController extends Controller
{

    public function index(Request $request)
    {

        $query = Destination::query();


        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        $destinations = $query->paginate(9);


        return view('travel.travel-guide', compact('destinations'));
    }

    public function show($id)
    {
        $destination = Destination::with('tripTemplates')->findOrFail($id);
        return view('travel.destination-detail', compact('destination'));
    }
}
