<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// User routes
Route::prefix('user')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'showSignInForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'postSignIn'])->name('post.signin');

    // Protecting the user home route
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    Route::get('/sign-up', [AuthController::class, 'showSignUpForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'registerUser'])->name('signup.submit');

    // Protected routes
    Route::get('/page', [PageController::class, 'userPage'])->name('user')->middleware('auth');
    Route::get('/edit-profile', [PageController::class, 'edit'])->name('edit')->middleware('auth');
});

// Trip routes
Route::prefix('trip')->middleware('auth')->group(function () {
    Route::get('/create-trip', [TripController::class, 'create'])->name('trips.create');
    Route::post('/submit-trip', [TripController::class, 'store'])->name('trips.store');

    Route::get('/itinerary', [PageController::class, 'itinerary'])->name('itinerary');

    Route::get('/itinerary/create', [ItineraryController::class, 'create'])->name('itinerary.create'); // Route to create itinerary
    Route::post('/itinerary/store', [ItineraryController::class, 'store'])->name('itinerary.store'); // Route to store itinerary
    Route::get('/itinerary/{id}', [ItineraryController::class, 'show'])->name('itinerary.show'); // Route to show an itinerary


    Route::get('/information', [PageController::class, 'tripInformation'])->name('tripinformation');
    Route::get('/list', [PageController::class, 'tripList'])->name('tripList');
    Route::get('/details', [PageController::class, 'tripDetails'])->name('tripDetails');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
