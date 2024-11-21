<?php

// app/Http/Controllers/TravelController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravelController extends Controller
{
    // Function to return the travel guide page
    public function index()
    {
        // You can pass additional data to the view if necessary
        return view('travel.travel-guide'); // This references the file located in resources/views/travel/travel-guide.blade.php
    }
}
