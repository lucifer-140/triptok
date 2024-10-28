<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home'); // Ensure 'home' corresponds to a view file in your resources/views directory
    }
}
