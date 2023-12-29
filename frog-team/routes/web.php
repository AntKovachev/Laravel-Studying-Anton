<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');

//Wildcard
Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::post('newsletter', NewsletterController::class);

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

//Reset Password
Route::get('/forgot-password', function () {
    return view('admin.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('admin.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

// Admin
Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
});

Route::get('/account', [AccountController::class, 'index'])->middleware('auth');

Route::get('/admin/users', [AccountController::class, 'showUsers'])->middleware('auth');
Route::get('/admin/friends', [AccountController::class, 'showFriends'])->middleware('auth');
Route::get('/admin/blocked-users', [AccountController::class, 'showBlockedUsers'])->middleware('auth');
Route::get('/admin/friend-requests', [AccountController::class, 'showFriendRequests'])->middleware('auth');
Route::post('/accept-friend-request/{user}', [AccountController::class, 'acceptFriendRequest'])->name('accept.friend.request')->middleware('auth');
Route::post('/decline-friend-request/{user}', [AccountController::class, 'declineFriendRequest'])->name('decline.friend.request')->middleware('auth');


Route::get('/add-friend/{user}', [FriendController::class, 'addFriend'])->name('add.friend')->middleware('auth');
Route::post('/cancel-friend-request/{user}', [FriendController::class, 'cancelFriendRequest'])->name('cancel.friend.request')->middleware('auth');
Route::get('/remove-friend/{friend}', [FriendController::class, 'removeFriend'])->name('remove.friend')->middleware('auth');
Route::get('/block-user/{user}', [FriendController::class, 'block'])->name('block.user')->middleware('auth');
Route::post('/unblock-user/{user}', [FriendController::class, 'unblock'])->name('unblock.user')->middleware('auth');

Route::get('/profiles/{user}', [UserProfileController::class, 'show'])->name('profiles.show')->middleware('auth');

