<?php

// app/Models/Flight.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = ['day_id', 'flight_number', 'date', 'departure_time', 'arrival_time', 'cost'];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
