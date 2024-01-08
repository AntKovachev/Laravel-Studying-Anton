<?php

namespace App\Http\Controllers;
use App\Services\Newsletter;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Hootlex\Friendships\Traits\Friendable;

class AccountController extends Controller
{
    use Friendable;

    public function index(Newsletter $newsletter)
    {
        $user = auth()->user();
        $isSubscribed = $newsletter->isSubscribed($user->email);
        
        return view('admin.account', compact('isSubscribed'));
    }

    public function showUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('username', 'like', "%{$searchTerm}%");
        }

        $users = $query->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function showFriends(Request $request)
    {
        $user = $request->user();
        $search = $request->input('search');

        $friendsQuery = $user->getFriendsQueryBuilder();

        if ($search) {
            $friendsQuery->where('username', 'like', '%' . $search . '%');
        }

        $friends = $friendsQuery->paginate(10);

        return view('admin.friends', compact('friends'));
    }

    public function messageFriend()
    {
        return view('admin.message');
    }

    public function showBlockedUsers(Request $request)
    {
        $user = $request->user();
        $search = $request->input('search');

        $blockedUsersList = $user->getBlockedFriendshipsByCurrentUser();
        $blockedIds = $blockedUsersList->pluck('recipient_id');

        $blockedUsers = User::whereIn('id', $blockedIds)
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.blocked', compact('blockedUsers', 'search'));
    }


    public function showFriendRequests(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $friendRequestIds = $user->getFriendRequests()->pluck('sender_id');

        $friendRequests = User::whereIn('id', $friendRequestIds)
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.friend-requests', compact('friendRequests', 'search'));
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

    public function unsubscribe(Newsletter $newsletter)
    {
        $user = auth()->user();

        if ($newsletter->isSubscribed($user->email)) {
            $newsletter->unsubscribe($user->email);
            return redirect('/account')->with('success', 'Successfully unsubscribed from the newsletter.');
        }

        return redirect('/account')->withErrors(['error' => 'You are not subscribed to the newsletter.']);
    }
}
