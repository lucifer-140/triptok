<?php

use App\Http\Controllers\{
    PageController,
    GuestController,
    AuthController,
    TripController,
    ItineraryController,
    DayController,
    HomeController,
    ActivityController,
    AccommodationController,
    FlightController,
    ProfileController,
    TransportController,
    CalendarController,
    FriendController,
    TripShareController,
    TripDuplicateController,
    NotificationController,
    TravelController
};

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

        // Friendship routes
        Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
        Route::post('/send-request/{receiver}', [FriendController::class, 'sendRequest'])->name('sendRequest');
        Route::post('/accept-request/{sender}', [FriendController::class, 'acceptRequest'])->name('acceptRequest');
        Route::post('/decline-request/{sender}', [FriendController::class, 'declineRequest'])->name('declineRequest');
        Route::post('/remove-friend/{friend}', [FriendController::class, 'removeFriend'])->name('removeFriend');

        // Notification routes
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/trips/share/accept/{sharedTrip}', [NotificationController::class, 'accept'])->name('notifications.accept');
        Route::get('/trips/share/reject/{sharedTrip}', [NotificationController::class, 'reject'])->name('notifications.reject');
    });
});

// Trip routes
Route::prefix('trip')->middleware('auth')->group(function () {
    Route::get('/create-trip', [TripController::class, 'create'])->name('trips.create');
    Route::post('/submit-trip', [TripController::class, 'store'])->name('trips.store');

    // Day routes
    Route::post('/create-day', [DayController::class, 'store'])->name('day.store');
    Route::get('/day/{day}', [DayController::class, 'show'])->name('day.show');

    // Trip update and status routes
    Route::put('/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::post('/{trip}/status/{status}', [TripController::class, 'updateStatus'])->name('trip.updateStatus');

    // Activity routes
    Route::prefix('activities')->group(function () {
        Route::get('/create/{day}', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/store/{day}', [ActivityController::class, 'store'])->name('activities.store');
        Route::get('/edit/{activity}', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::put('/update/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/delete/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    });

    // Accommodation routes
    Route::prefix('accommodation')->group(function () {
        Route::get('/create/{day}', [AccommodationController::class, 'create'])->name('accommodation.create');
        Route::post('/store/{day}', [AccommodationController::class, 'store'])->name('accommodation.store');
        Route::get('/edit/{accommodation}', [AccommodationController::class, 'edit'])->name('accommodation.edit');
        Route::put('/update/{accommodation}', [AccommodationController::class, 'update'])->name('accommodation.update');
        Route::delete('/delete/{accommodation}', [AccommodationController::class, 'destroy'])->name('accommodation.destroy');
    });

    // Flight routes
    Route::prefix('flights')->group(function () {
        Route::get('/create/{day}', [FlightController::class, 'create'])->name('flights.create');
        Route::post('/store/{day}', [FlightController::class, 'store'])->name('flights.store');
        Route::get('/edit/{flight}', [FlightController::class, 'edit'])->name('flights.edit');
        Route::put('/update/{flight}', [FlightController::class, 'update'])->name('flights.update');
        Route::delete('/delete/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');
    });

    // Transport routes
    Route::prefix('transport')->group(function () {
        Route::get('/create/{day}', [TransportController::class, 'create'])->name('transport.create');
        Route::post('/store/{day}', [TransportController::class, 'store'])->name('transport.store');
        Route::get('/edit/{transport}', [TransportController::class, 'edit'])->name('transport.edit');
        Route::put('/update/{transport}', [TransportController::class, 'update'])->name('transport.update');
        Route::delete('/delete/{transport}', [TransportController::class, 'destroy'])->name('transport.destroy');
    });

    // Itinerary routes
    Route::get('/itinerary/create/{trip}', [ItineraryController::class, 'create'])->name('itinerary.create');
    Route::post('/itinerary/store', [ItineraryController::class, 'store'])->name('itinerary.save');

    // Trip listing and details
    Route::get('/list', [TripController::class, 'tripList'])->name('tripList');
    Route::get('trips/pending', [TripController::class, 'pendingTrips'])->name('trips.pending');
    Route::get('trips/ongoing', [TripController::class, 'ongoingTrips'])->name('trips.ongoing');
    Route::get('trips/finished', [TripController::class, 'finishedTrips'])->name('trips.finished');
    Route::get('/{trip_id}/details', [TripController::class, 'showDetails'])->name('trips.details');
    Route::delete('/{trip}', [TripController::class, 'destroy'])->name('trip.delete');
    Route::get('/{itineraryId}/downloadICS', [CalendarController::class, 'downloadICS'])->name('trip.downloadICS');
});

// Travel routes
Route::prefix('travel')->middleware('auth')->group(function () {
    Route::get('/travel-guide', [TravelController::class, 'index'])->name('travel.index');
    Route::get('destination/{id}', [TravelController::class, 'show'])->name('destination.show');
});

// Authentication routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [GuestController::class, 'index'])->name('guest.home');

// Password reset routes
Route::get('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');

// Email verification routes
Route::get('/verify-email', [AuthController::class, 'showVerificationForm'])->name('verify-email');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email.post');

// Trip sharing routes
Route::get('/trips/{trip_id}/share', [TripShareController::class, 'create'])->name('trips.share.form');
Route::post('/trips/{trip_id}/share', [TripShareController::class, 'share'])->name('trips.share');
Route::get('/trips/share/accept/{sharedTrip}', [TripShareController::class, 'accept'])->name('trips.share.accept');
Route::get('/trips/share/reject/{sharedTrip}', [TripShareController::class, 'reject'])->name('trips.share.reject');

Route::get('/trips/{trip}/duplicate', [TripDuplicateController::class, 'duplicate'])->name('trips.duplicate');



Route::view('/about-us', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::view('/help', 'pages.help')->name('help');
