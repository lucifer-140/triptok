<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class PageController extends Controller
{
    // public function home()
    // {
    //     return view('home');
    // }

    // public function createTrip()
    // {
    //     return view('trips.create-trip');
    // }

    // public function itinerary()
    // {
    //     return view('trips.itinerary');
    // }

    public function tripInformation()
    {
        return view('trips.tripinformation');
    }

    public function tripList()
    {
        return view('trips.tripList');
    }

    public function tripDetails()
    {
        return view('trips.tripDetails');
    }

    // public function signIn()
    // {
    //     return view('auth.signin');
    // }

    // public function signUp()
    // {
    //     return view('auth.signup');
    // }
    public function userPage()
    {
        return view('profile.user');
    }
    public function edit()
    {
        return view('profile.edit');
    }

}

