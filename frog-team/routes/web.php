<?php

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

// Public Routes
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);
Route::post('newsletter', NewsletterController::class)->name('newsletter.subscribe');
Route::post('/unsubscribe', [AccountController::class, 'unsubscribe'])->name('unsubscribe');

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [SessionsController::class, 'create'])->name('login');
    Route::post('login', [SessionsController::class, 'store']);
    Route::get('/forgot-password', function () {
        return view('admin.forgot-password');
    })->name('password.request');
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'If this e-mail exists in our database, we will send a password reset link.')
            : back()->with('success', 'If this e-mail exists in our database, we will send a password reset link.');
    })->name('password.email');
    Route::get('/reset-password/{token}', function (string $token) {
        return view('admin.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [SessionsController::class, 'destroy']);
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/profiles/{user}', [UserProfileController::class, 'show'])->name('profiles.show');
    Route::get('/add-friend/{user}', [FriendController::class, 'addFriend'])->name('add.friend');
    Route::post('/cancel-friend-request/{user}', [FriendController::class, 'cancelFriendRequest'])->name('cancel.friend.request');
    Route::get('/remove-friend/{friend}', [FriendController::class, 'removeFriend'])->name('remove.friend');
    Route::get('/block-user/{user}', [FriendController::class, 'block'])->name('block.user');
    Route::post('/unblock-user/{user}', [FriendController::class, 'unblock'])->name('unblock.user');
    Route::resource('admin/posts', AdminPostController::class)->except('show');
    Route::get('/admin/users', [AccountController::class, 'showUsers'])->name('all.users');
    Route::get('/admin/friends', [AccountController::class, 'showFriends'])->name('friends');
    Route::get('/admin/blocked-users', [AccountController::class, 'showBlockedUsers'])->name('blocked.users');
    Route::get('/admin/friend-requests', [AccountController::class, 'showFriendRequests'])->name('friend.requests');
    Route::get('/messages', [AccountController::class, 'showMessages'])->name('messages.show');
    Route::post('/accept-friend-request/{user}', [AccountController::class, 'acceptFriendRequest'])->name('accept.friend.request');
    Route::post('/decline-friend-request/{user}', [AccountController::class, 'declineFriendRequest'])->name('decline.friend.request');
});

// Admin Routes
Route::middleware(['can:admin'])->group(function () {
    
});
