<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PasswordResetController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Password reset link sent!');
        }

        return back()->withErrors(['email' => trans($response)]);
    }


    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }


    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('signin')->with('success', 'Password reset successful');
        }

        return back()->withErrors(['email' => trans($response)]);
    }
}
