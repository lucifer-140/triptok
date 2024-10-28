<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Main routes
Route::get('/', [PageController::class, 'home'])->name('home');

// Trip routes
Route::prefix('trip')->group(function () {
    Route::get('/create', [PageController::class, 'createTrip'])->name('create-trip');
    Route::get('/itinerary', [PageController::class, 'itinerary'])->name('itinerary');
    Route::get('/information', [PageController::class, 'tripInformation'])->name('tripinformation');
    Route::get('/index', [PageController::class, 'tripIndex'])->name('index');
    Route::get('/details', [PageController::class, 'tripDetails'])->name('tripDetails');
});

// User routes
Route::prefix('user')->group(function () {
    Route::get('/sign-in', [PageController::class, 'signIn'])->name('signin');
    Route::post('/sign-in', [AuthController::class, 'handleSignIn'])->name('post.signin');

    Route::get('/sign-up', [AuthController::class, 'showSignUpForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'registerUser'])->name('signup.submit');

    Route::get('/page', [PageController::class, 'userPage'])->name('user');
    Route::get('/edit-profile', [PageController::class, 'edit'])->name('edit');
});

