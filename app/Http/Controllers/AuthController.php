<?php

namespace App\Http\Controllers;

use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // For hashing passwords
use Illuminate\Support\Facades\Validator; // For validation
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


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

        // Generate a 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Create the user but mark as unverified initially
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_verified' => false,
            'verification_code' => $verificationCode,
        ]);

        // Send the verification code to the user's email
        Mail::send('emails.verification_code', ['code' => $verificationCode], function ($message) use ($user) {
            $message->to($user->email)->subject('Your Verification Code');
        });

        // Redirect to a page where the user can enter the verification code
        return redirect()->route('verify-email')->with('message', 'A verification code has been sent to your email.');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->code)
                    ->first();

        if ($user) {
            $user->is_verified = true;
            $user->verification_code = null; // Clear the verification code
            $user->save();

            return redirect()->route('signin')->with('success', 'Email verified successfully! You can now sign in.');
        }

        return redirect()->back()->with('error', 'Invalid verification code. Please try again.');
    }

    public function showVerificationForm()
    {
        return view('auth.verify_email');
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
            // Check if the user is verified
            $user = Auth::user();
            if (!$user->is_verified) {
                // Generate a new 6-digit verification code
                $verificationCode = rand(100000, 999999);
                $user->verification_code = $verificationCode;
                $user->save();

                // Send the verification code to the user's email
                Mail::send('emails.verification_code', ['code' => $verificationCode], function ($message) use ($user) {
                    $message->to($user->email)->subject('Your Verification Code');
                });

                // Log the user out if not verified
                Auth::logout();
                return redirect()->route('verify-email')
                    ->with('error', 'Your account is not verified. A new verification code has been sent to your email.');
            }

            // If verified, redirect to the home page
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
