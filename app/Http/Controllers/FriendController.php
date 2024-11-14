<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function sendRequest(User $receiver)
    {
        if ($receiver->id == auth()->id()) {
            return redirect()->back()->with('error', 'You cannot send a friend request to yourself.');
        }

        // Check if a friend request exists with "declined" status
        $existingRequest = FriendRequest::where('sender_id', auth()->id())
                                        ->where('receiver_id', $receiver->id)
                                        ->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return redirect()->back()->with('error', 'Friend request already sent.');
            } elseif ($existingRequest->status === 'declined') {
                // Update status to "pending" if previously declined
                $existingRequest->update(['status' => 'pending']);
                return redirect()->back()->with('success', 'Friend request resent.');
            }
        } else {
            // Create a new friend request if none exists
            FriendRequest::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiver->id,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Friend request sent.');
        }
    }



    public function acceptRequest(User $sender)
    {
        $request = FriendRequest::where('sender_id', $sender->id)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            return redirect()->back()->with('error', 'Friend request not found.');
        }

        $request->update(['status' => 'accepted']);

        auth()->user()->friends()->attach($sender->id);
        $sender->friends()->attach(auth()->id());

        return redirect()->back()->with('success', 'Friend request accepted.');
    }

    public function declineRequest(User $sender)
    {
        $request = FriendRequest::where('sender_id', $sender->id)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$request) {
            return redirect()->back()->with('error', 'Friend request not found.');
        }

        $request->update(['status' => 'declined']);

        return redirect()->back()->with('success', 'Friend request declined.');
    }

    public function removeFriend(User $friend)
    {
        $user = auth()->user();

        // Remove the friend relationship for both users
        $user->friends()->detach($friend->id);
        $friend->friends()->detach($user->id);

        return redirect()->back()->with('success', 'Friend removed successfully.');
    }



    public function index()
    {
        $user = auth()->user();

        // Fetch friends where status is accepted in the friends table
        $friends = $user->friends;

        // Fetch received friend requests that are pending
        $receivedRequests = $user->receivedRequests()->where('status', 'pending')->get();

        // Fetch sent friend requests that are pending
        $sentRequests = $user->sentRequests()->where('status', 'pending')->get();

        // Find users who are not friends and haven't received/sent a friend request
        $nonFriends = User::where('id', '!=', $user->id)
            ->whereDoesntHave('friends', function ($query) use ($user) {
                $query->where('friend_id', $user->id);
            })
            ->whereDoesntHave('receivedRequests', function ($query) use ($user) {
                $query->where('sender_id', $user->id);
            })
            ->whereDoesntHave('sentRequests', function ($query) use ($user) {
                $query->where('receiver_id', $user->id);
            })
            ->get();

        // Return the view and pass the data for each section
        return view('friends.index', compact('friends', 'receivedRequests', 'sentRequests', 'nonFriends'));
    }



}
