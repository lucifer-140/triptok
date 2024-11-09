<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'destination',
        'start_date',
        'end_date',
        'budget',
        'currency',
    ];

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function status()
    {
        return $this->hasOne(TripStatus::class);
    }

}
