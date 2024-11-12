<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index()
    {
        return view('friends.index'); // This will reference the friends/index view
    }
}
