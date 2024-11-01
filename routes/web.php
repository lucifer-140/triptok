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


    Route::get('/itinerary/create/{trip}', [ItineraryController::class, 'create'])->name('itinerary.create');
    // Route::get('/itinerary/{id}', [ItineraryController::class, 'show'])->name('itinerary.show'); // Route to show an itinerary
    Route::post('/itinerary/store', [ItineraryController::class, 'store'])->name('itinerary.save');


    Route::get('/information', [PageController::class, 'tripInformation'])->name('tripinformation');
    Route::get('/list', [PageController::class, 'tripList'])->name('tripList');
    Route::get('/details', [PageController::class, 'tripDetails'])->name('tripDetails');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/test-save', function () {
    $request = new \Illuminate\Http\Request();
    $request->replace([
        'itinerary_id' => 1, // Replace with a valid ID
        'days' => [
            ['day' => 1, 'date' => '2024-11-01']
        ],
        'activities' => [
            ['title' => 'Activity 1', 'start_time' => '08:00:00', 'end_time' => '09:00:00', 'estimated_budget' => 100, 'description' => 'First activity']
        ],
        'transports' => [
            ['type' => 'Bus', 'departure_time' => '10:00:00', 'cost' => 20]
        ],
        'accommodations' => [
            ['name' => 'Hotel', 'check_in_date' => '2024-11-01', 'check_out_date' => '2024-11-02', 'cost' => 150]
        ],
        'flights' => [
            ['flight_number' => 'ABC123', 'date' => '2024-11-01', 'departure_time' => '14:00:00', 'arrival_time' => '16:00:00', 'cost' => 200]
        ],
    ]);

    return app(ItineraryController::class)->save($request);
});
