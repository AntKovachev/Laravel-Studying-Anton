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
}
