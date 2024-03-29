<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function __invoke(Newsletter $newsletter)
    {   
        request()->validate(['email' => 'required|email']);

        try {
            $newsletter->subscribe(request('email'));
        } catch (Exception $e) {
            return redirect('/account')
                ->withErrors(['email' => 'You cannot re-subscribe, please contact our support!'])
                ->withInput()
                ->withFragment('newsletter');
        }

        return redirect('/account')->with('success', 'You are now signed up for our newsletter!');
    }
}
