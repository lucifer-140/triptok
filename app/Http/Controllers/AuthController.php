<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{

    public function showSignUpForm()
    {
        return view('auth.signup');
    }


    public function registerUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15|unique:users,phone_number',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $verificationCode = rand(100000, 999999);


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_verified' => false,
            'verification_code' => $verificationCode,
        ]);


        Mail::send('emails.verification_code', ['code' => $verificationCode], function ($message) use ($user) {
            $message->to($user->email)->subject('Your Verification Code');
        });


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
            $user->verification_code = null;
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
        return view('auth.signin');
    }


    public function postSignIn(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            if (!$user->is_verified) {

                $verificationCode = rand(100000, 999999);
                $user->verification_code = $verificationCode;
                $user->save();


                Mail::send('emails.verification_code', ['code' => $verificationCode], function ($message) use ($user) {
                    $message->to($user->email)->subject('Your Verification Code');
                });


                Auth::logout();
                return redirect()->route('verify-email')
                    ->with('error', 'Your account is not verified. A new verification code has been sent to your email.');
            }


            return redirect()->route('home')->with('success', 'You are now signed in.');
        }


        return redirect()->back()->with('error', 'Invalid credentials. Please try again.')->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/user/sign-in');
    }

}
