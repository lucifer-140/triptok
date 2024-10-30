<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['itinerary_id', 'day', 'date'];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'day_activity');
    }

    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'day_transport');
    }

    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class, 'day_accommodation');
    }

    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'day_flight');
    }
}
