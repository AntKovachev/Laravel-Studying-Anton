<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        if (request()->path() == 'profiles/' . auth()->user()->id) {
            return redirect('/account');
        }
        
        return view('profiles.show', compact('user'));
    }
}
