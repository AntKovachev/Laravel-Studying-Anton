<?php
// app/Http/Controllers/FriendController.php

namespace App\Http\Controllers;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Hootlex\Friendships\Models\Friendship;
use App\Models\User;

class FriendController extends Controller
{   
    use Friendable;
    const STATUS_FRIENDS = 1;

    public function addFriend($recipientId)
    {
        // Get the authenticated user
        $user = auth()->user(); // You may use your own method to get the authenticated user

        // Get the recipient user
        $recipient = User::find($recipientId);

        // Check if the user can befriend the recipient
        if ($user->canBefriend($recipient)) {
            // Befriend the user
            $friendship = $user->befriend($recipient);
            // ... handle successful friend request
            return back()->with('success', 'Friend request sent!');
        } else {
            // User is already a friend, handle accordingly
            // ... return a message or perform other actions
            return back()->with('success', 'User is already your friend!');
        }
    }
}
