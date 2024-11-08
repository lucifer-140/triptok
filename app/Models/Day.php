<?php

// app/Models/Day.php

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
        return $this->hasMany(Activity::class);
    }

    public function transports()
    {
        return $this->hasMany(Transport::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}

