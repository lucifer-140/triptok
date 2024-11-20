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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\TripShareController;
use App\Http\Controllers\NotificationController;



use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;

// User routes
Route::prefix('user')->group(function () {
    // Authentication routes
    Route::get('/sign-in', [AuthController::class, 'showSignInForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'postSignIn'])->name('post.signin');
    Route::get('/login', [AuthController::class, 'showSignInForm'])->name('login');

    Route::get('/sign-up', [AuthController::class, 'showSignUpForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'registerUser'])->name('signup.submit');

    // Protecting the user home route
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    // Profile routes (protected by authentication middleware)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Friendship routes (protected by authentication middleware)
    Route::middleware('auth')->group(function () {
        Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');

        Route::post('/send-request/{receiver}', [FriendController::class, 'sendRequest'])->name('sendRequest');
        Route::post('/accept-request/{sender}', [FriendController::class, 'acceptRequest'])->name('acceptRequest');
        Route::post('/decline-request/{sender}', [FriendController::class, 'declineRequest'])->name('declineRequest');
        Route::post('/remove-friend/{friend}', [FriendController::class, 'removeFriend'])->name('removeFriend');

    });

    Route::middleware('auth')->group(function () {
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/trips/share/accept/{sharedTrip}', [NotificationController::class, 'accept'])->name('notifications.accept');
        Route::get('/trips/share/reject/{sharedTrip}', [NotificationController::class, 'reject'])->name('notifications.reject');

    });

});



// Trip routes
Route::prefix('trip')->middleware('auth')->group(function () {
    Route::get('/create-trip', [TripController::class, 'create'])->name('trips.create');
    Route::post('/submit-trip', [TripController::class, 'store'])->name('trips.store');

    // Route to store a new day
    Route::post('/create-day', [DayController::class, 'store'])->name('day.store');

    // Route to show the day plan page (day.blade.php)
    Route::get('/day/{day}', [DayController::class, 'show'])->name('day.show');

    // Add the PUT route to update trip details
    Route::put('/{trip}', [TripController::class, 'update'])->name('trips.update');

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

    Route::post('/{trip}/status/{status}', [TripController::class, 'updateStatus'])->name('trip.updateStatus');

    //
    Route::get('/list', [TripController::class, 'tripList'])->name('tripList');

    Route::get('trips/pending', [TripController::class, 'pendingTrips'])->name('trips.pending');
    Route::get('trips/ongoing', [TripController::class, 'ongoingTrips'])->name('trips.ongoing');
    Route::get('trips/finished', [TripController::class, 'finishedTrips'])->name('trips.finished');



    Route::get('/{trip_id}/details', [TripController::class, 'showDetails'])->name('trips.details');

    Route::delete('/{trip}', [TripController::class, 'destroy'])->name('trip.delete');

    Route::get('/{itineraryId}/downloadICS', [CalendarController::class, 'downloadICS'])->name('trip.downloadICS');



});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [GuestController::class, 'index'])->name('guest.home');




// Show the reset password request form
Route::get('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');

// Send the reset password link
Route::post('password/email', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// Show the reset password form
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');

// Reset the password
Route::post('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');

// Route::post('/register', [AuthController::class, 'registerUser'])->name('register');
Route::get('/verify-email', [AuthController::class, 'showVerificationForm'])->name('verify-email');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email.post');


// Route to show the share trip modal (if needed, you can remove this if using the modal on every trip view)
Route::get('/trips/{trip_id}/share', [TripShareController::class, 'create'])->name('trips.share.form');

// Route to handle the sharing action
// Route::post('/trips/share', [TripShareController::class, 'share'])->name('trips.share');


Route::post('/trips/{trip_id}/share', [TripShareController::class, 'share'])->name('trips.share');


// Route::get('/shared-trips', [TripShareController::class, 'notifications'])->name('notifications');



// Route to accept a shared trip
Route::get('/trips/share/accept/{sharedTrip}', [TripShareController::class, 'accept'])->name('trips.share.accept');

// Route to reject a shared trip
Route::get('/trips/share/reject/{sharedTrip}', [TripShareController::class, 'reject'])->name('trips.share.reject');
