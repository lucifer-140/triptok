<?php

namespace App\Http\Controllers;

use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // For hashing passwords
use Illuminate\Support\Facades\Validator; // For validation
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the signup form
    public function showSignUpForm()
    {
        return view('auth.signup'); // Return the signup view
    }

    // Handle user registration
    public function registerUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15|unique:users,phone_number',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect to sign-in page
        return redirect()->route('signin')->with('success', 'Account created successfully! Please sign in.');
    }

    public function showSignInForm()
    {
        return view('auth.signin'); // Ensure this matches your view file name
    }

    public function postSignIn(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication passed, redirect to the home page
            return redirect()->route('home')->with('success', 'You are now signed in.');
        }

        // Authentication failed, redirect back with error
        return redirect()->back()->with('error', 'Invalid credentials. Please try again.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        return redirect('/user/sign-in'); // Redirect to sign-in page after logout
    }

}
