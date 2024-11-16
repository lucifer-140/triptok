<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\SharedTrip;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // block code bellow to use local server
        // if(config('app.env') === 'local'){
        //     URL::forceScheme('https');
        // }

        // View composer for passing data to all views
        View::composer('layouts.app', function ($view) {
            $user = auth()->user();

            // Count pending received requests and shared trips
            $receivedRequestsCount = $user->receivedRequests()->where('status', 'pending')->count();
            $sharedTripsCount = SharedTrip::where('user_id', $user->id)->where('status', 'pending')->count();

            // Share the counts with the view
            $view->with('receivedRequestsCount', $receivedRequestsCount);
            $view->with('sharedTripsCount', $sharedTripsCount);
        });
    }
}
