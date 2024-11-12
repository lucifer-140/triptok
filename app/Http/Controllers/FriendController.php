<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // Display all users except the authenticated one
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('friends.index', compact('users'));
    }

    // Search function for filtering users
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Fetch users based on the search query
        $users = User::where('first_name', 'like', "%$query%")
                    ->orWhere('last_name', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%")
                    ->orWhere('phone_number', 'like', "%$query%")
                    ->get();

        return response()->json(['users' => $users]);
    }

    // Display the list of friends, pending, and rejected requests
    public function friendsList()
    {
        // Fetch all friendships related to the authenticated user
        $friendships = Friendship::where(function ($query) {
            $query->where('user_id', auth()->id())
                  ->orWhere('friend_id', auth()->id());
        })
        ->get();

        // Separate the friendships based on status
        $acceptedFriends = $friendships->filter(function ($friendship) {
            return $friendship->status === 'accepted';
        });

        $pendingRequests = $friendships->filter(function ($friendship) {
            return $friendship->status === 'pending';
        });

        $rejectedRequests = $friendships->filter(function ($friendship) {
            return $friendship->status === 'rejected';
        });

        // Eager load the related user data for each friendship
        $acceptedFriends->load('user', 'friend');
        $pendingRequests->load('user', 'friend');
        $rejectedRequests->load('user', 'friend');

        // Return the view with data
        return view('friends.list', compact('acceptedFriends', 'pendingRequests', 'rejectedRequests'));
    }

    public function remove(Friendship $friendship)
    {
        // Check if the authenticated user is part of this friendship
        if (auth()->id() !== $friendship->user_id && auth()->id() !== $friendship->friend_id) {
            return redirect()->route('friends.list')->with('error', 'You are not authorized to remove this friend.');
        }

        // Delete the friendship
        $friendship->delete();

        // Redirect back with a success message
        return redirect()->route('friends.list')->with('success', 'Friend removed successfully.');
    }

}
