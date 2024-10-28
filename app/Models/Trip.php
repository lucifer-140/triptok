<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_title',
        'destination',
        'start_date',
        'end_date',
        'total_budget',
        'currency',
        'total_days',
    ];

    // Define any relationships, e.g., itineraries
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class); // Adjust this according to your model
    }
}
