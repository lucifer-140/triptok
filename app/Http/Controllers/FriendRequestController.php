<?php
// app/Http/Controllers/FriendRequestController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;  // Updated to use Friendship model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendRequestController extends Controller
{
    // Send Friend Request
    public function sendRequest($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent sending request to self
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'You cannot send a friend request to yourself.');
        }

        // Check if a request already exists
        $existingRequest = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'You have already sent or received a friend request.');
        }

        // Send the request
        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Friend request sent!');
    }

    // Accept Friend Request
    public function acceptRequest($requestId)
    {
        $request = Friendship::findOrFail($requestId);

        if ($request->friend_id != Auth::id() || $request->status != 'pending') {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        $request->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Friend request accepted!');
    }

    // Reject Friend Request
    public function rejectRequest($requestId)
    {
        $request = Friendship::findOrFail($requestId);

        if ($request->friend_id != Auth::id() || $request->status != 'pending') {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        $request->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Friend request rejected!');
    }
}
