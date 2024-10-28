<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'trip_day', 'activity_title', 'activity_start_time', 'activity_end_time',
        'activity_budget', 'activity_description', 'transport_title', 'transport_start_time',
        'transport_end_time', 'transport_budget', 'accommodation_name', 'accommodation_checkin',
        'accommodation_checkout', 'accommodation_budget', 'flight_number', 'flight_departure',
        'flight_arrival', 'flight_cost'
    ];
}
