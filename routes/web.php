<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;



// Trip routes
Route::prefix('trip')->group(function () {

    Route::get('/create-trip', [TripController::class, 'create'])->name('trips.create');
    Route::post('/submit-trip', [TripController::class, 'store'])->name('trips.store');



    Route::get('/itinerary', [PageController::class, 'itinerary'])->name('itinerary');
    Route::get('/information', [PageController::class, 'tripInformation'])->name('tripinformation');
    Route::get('/index', [PageController::class, 'tripIndex'])->name('index');
    Route::get('/details', [PageController::class, 'tripDetails'])->name('tripDetails');
});

// User routes
Route::prefix('user')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'showSignInForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'postSignIn'])->name('post.signin');

    // Protecting the user home route
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    Route::get('/sign-up', [AuthController::class, 'showSignUpForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'registerUser'])->name('signup.submit');

    Route::get('/page', [PageController::class, 'userPage'])->name('user')->middleware('auth');
    Route::get('/edit-profile', [PageController::class, 'edit'])->name('edit')->middleware('auth');
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
