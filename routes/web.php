<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TransportController;
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

    // Route to store a new day
    Route::post('/create-day', [DayController::class, 'store'])->name('day.store');

    // Route to show the day plan page (day.blade.php)
    Route::get('/day/{day}', [DayController::class, 'show'])->name('day.show');

    // Activity routes
    Route::get('/activities/create/{day}', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities/store/{day}', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/edit/{activity}', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/update/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/delete/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');


    // Accommodation routes
    Route::get('/accommodation/create/{day}', [AccommodationController::class, 'create'])->name('accommodation.create');
    Route::post('/accommodation/store/{day}', [AccommodationController::class, 'store'])->name('accommodation.store');
    Route::get('/accommodation/edit/{accommodation}', [AccommodationController::class, 'edit'])->name('accommodation.edit');
    Route::put('/accommodation/update/{accommodation}', [AccommodationController::class, 'update'])->name('accommodation.update');
    Route::delete('/accommodation/delete/{accommodation}', [AccommodationController::class, 'destroy'])->name('accommodation.destroy');

    // Flight routes
    Route::get('/flights/create/{day}', [FlightController::class, 'create'])->name('flights.create');
    Route::post('/flights/store/{day}', [FlightController::class, 'store'])->name('flights.store');
    Route::get('/flights/edit/{flight}', [FlightController::class, 'edit'])->name('flights.edit');
    Route::put('/flights/update/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::delete('/flights/delete/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');

    // Transport routes
    Route::get('/transport/create/{day}', [TransportController::class, 'create'])->name('transport.create');
    Route::post('/transport/store/{day}', [TransportController::class, 'store'])->name('transport.store');
    Route::get('/transport/edit/{transport}', [TransportController::class, 'edit'])->name('transport.edit');
    Route::put('/transport/update/{transport}', [TransportController::class, 'update'])->name('transport.update');
    Route::delete('/transport/delete/{transport}', [TransportController::class, 'destroy'])->name('transport.destroy');

    // Itinerary routes
    Route::get('/itinerary/create/{trip}', [ItineraryController::class, 'create'])->name('itinerary.create');
    Route::post('/itinerary/store', [ItineraryController::class, 'store'])->name('itinerary.save');

    Route::get('/information', [PageController::class, 'tripInformation'])->name('tripinformation');
    Route::get('/list', [PageController::class, 'tripList'])->name('tripList');
    Route::get('/details', [PageController::class, 'tripDetails'])->name('tripDetails');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [GuestController::class, 'index'])->name('guest.home');
