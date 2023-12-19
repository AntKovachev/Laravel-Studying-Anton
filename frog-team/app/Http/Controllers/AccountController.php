<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account');
    }

    public function showUsers()
    {
        $users = User::paginate(100);

        return view('admin.users', compact('users'));
    }
}
