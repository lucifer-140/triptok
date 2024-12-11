<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'country', 'trip_start_date', 'trip_end_date', 'day', 'date',
        'activity_id', 'activity_title', 'activity_start_time', 'activity_end_time',
        'activity_budget', 'activity_description', 'transport_type',
        'transport_departure_time', 'transport_arrival_time', 'transport_cost',
        'accommodation_name', 'accommodation_check_in', 'accommodation_check_out',
        'accommodation_cost'
    ];
}
