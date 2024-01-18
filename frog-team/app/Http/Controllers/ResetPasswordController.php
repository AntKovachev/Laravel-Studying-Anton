<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    // Display the password reset form
    public function showResetForm($token)
    {
        return view('admin.reset-password', ['token' => $token]);
    }

    // Handle the form submission and update the password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors(['email' => ['Invalid email']]);
        }

        // Verify that the new password is not the same as the old one
        if (Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => ['New password must be different from the old one']]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // This closure is only executed if the new password is valid.
                // You can update the password here.
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect('/')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
