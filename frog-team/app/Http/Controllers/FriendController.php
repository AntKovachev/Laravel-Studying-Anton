<?php

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
        $user = auth()->user();

        // Get the recipient user
        $recipient = User::find($recipientId);

        // Check if the user can befriend the recipient
        if ($user->canBefriend($recipient)) {
            // Befriend the user
            $user->befriend($recipient);
            
            return back()->with('success', 'Friend request sent!');
        } else if ($user->hasSentFriendRequestTo($recipient)) {
            // User is already a friend, handle accordingly
            return back()->with('success', 'Friend request already sent!');
        } else {
            return back()->with('success', 'User is already your friend!');
        }
    }

    public function removeFriend($friendId)
    {
        $user = auth()->user();
        $friend = User::find($friendId);

        // Check if the user is friends with the specified friend
        if ($user->isFriend($friend)) {
            // Remove the friend
            $user->unfriend($friend);

            return back()->with('success', 'Friend removed successfully!');
        } else {
            // Handle the case where the specified user is not a friend
            return back()->with('success', 'This user is not in your friend list!');
        }
    }

    public function cancelFriendRequest(User $user)
    {
        $authUser = auth()->user();

        // Check if a friend request has been sent
        if ($authUser->hasSentFriendRequestTo($user)) {
            // Cancel the friend request
            $authUser->cancelFriendRequest($user);

            return back()->with('success', 'Friend request canceled successfully!');
        }

        return back()->with('error', 'No friend request to cancel!');
    }

    public function block($recipientId)
    {
        $user = auth()->user();

        $recipient = User::find($recipientId);

        $user->blockFriend($recipient);

        return back()->with('success', 'Friend blocked successfully!');
    }

    public function unblock($recipientId)
    {
        $user = auth()->user();

        $blockedUser = User::find($recipientId);

        if ($user->hasBlocked($blockedUser)) {
            //Unbock the user
            $user->unblockFriend($blockedUser);

            return back()->with('success', $blockedUser->username . ' unblocked successfully!');
        } else {
            return back()->with('success', 'This user is not blocked!');
        }
    }
}
