<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BlockUserController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('tasks', TaskController::class);

    Route::resource('threads', ThreadController::class);

    Route::post('threads/{thread}/messages', [MessageController::class, 'store'])->name('threads.messages.store');

    Route::get('dashboard', function() {
        return Inertia::render('Dashboard');
    })->name('dashboard'); 

    // Route::get('/user/profile', function () {
    //     return Inertia::render('profiles/Index');
    // })->name('profiles.index');

    Route::resource('/users/{user}/profile', ProfileController::class)->only(['index']);

    // Friendship routes
    Route::resource('friends', FriendshipController::class, ['only' => ['index']]);
    Route::post('/friends/{user}/send', [FriendshipController::class, 'sendRequest']);
    Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept']);
    Route::post('/friends/{friendship}/decline', [FriendshipController::class, 'decline']);
    Route::post('/friends/{friendship}/cancel', [FriendshipController::class, 'cancelRequest']);
    Route::delete('/friends/{user}/remove', [FriendshipController::class, 'remove']);

    // Topic feeds & listings
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/{topic:slug}', [TopicController::class, 'show'])->name('topics.show');

    // Onboarding / Profile Topic Management (user_topic pivot)
    // Route::post('/user/topics', [UserTopicController::class, 'sync'])->name('user.topics.sync');

    // Moderation & Safety
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::post('/users/{user}/block', [BlockUserController::class, 'store'])->name('users.block');
    Route::delete('/users/{user}/unblock', [BlockUserController::class, 'destroy'])->name('users.unblock');
});

// Route::get('dashboard', function () {
//     $user = auth()->user();
//     // dd($user);
//     return Inertia::render('Dashboard', [
//         'tasks' => TaskResource::collection($user->tasks()->latest()->get()),
//     ]);
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::resource('Tasks', TaskController::class)
//     ->middleware(['auth', 'verified']);

require __DIR__.'/settings.php';
