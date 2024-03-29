<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {   
        // Validate the request
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate and log in the user
        // based on the provided attributes
        if (auth()->attempt($attributes)) {
            //Session fixation
            session()->regenerate();

            // Redirect with a success flash message
            return redirect('/')->with('success', 'Welcome back!');
        }

        // Auth failed
        throw ValidationException::withMessages([
            'password' => "The provided credentials are incorrect.. <a href='" . route('password.request') . "'><b><u>Forgot Password?</u></b></a>",
        ])->status(422)->errorBag('custom');
    }


    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
