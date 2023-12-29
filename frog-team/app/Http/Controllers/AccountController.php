<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Hootlex\Friendships\Traits\Friendable;

class AccountController extends Controller
{
    use Friendable;

    public function index()
    {
        return view('admin.account');
    }

    public function showUsers()
    {
        $users = User::paginate(100);

        return view('admin.users', compact('users'));
    }

    public function showFriends(Request $request)
    {
        $user = $request->user();

        $friends = $user->getFriends();
        
        return view('admin.friends', compact('friends'));
    }

    public function showBlockedUsers(Request $request)
    {
        $user = $request->user();
        
        $blockedUsersList = $user->getBlockedFriendshipsByCurrentUser();
        $blockedIds = [];

        foreach ($blockedUsersList as $blockedUser) {
            $id = $blockedUser->recipient_id;
            array_push($blockedIds, $id);
        }

        $blockedUsers = User::whereIn('id', $blockedIds)->get(['id', 'username']);

        return view('admin.blocked', compact('blockedUsers'));
    }

    public function showFriendRequests()
    {
        $user = auth()->user();

        $friendRequestIds = $user->getFriendRequests()->pluck('sender_id');

        $friendRequests = User::whereIn('id', $friendRequestIds)->get(['id', 'username']);

        return view('admin.friend-requests', compact('friendRequests'));
    }

    public function acceptFriendRequest(User $user)
    {
        auth()->user()->acceptFriendRequest($user);

        return redirect()->back()->with('success', 'Friend request accepted successfully.');
    }

    public function declineFriendRequest(User $user)
    {
        auth()->user()->denyFriendRequest($user);

        return redirect()->back()->with('success', 'Friend request declined successfully.');
    }
}
