<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = ['flight_number', 'departure', 'arrival', 'cost'];

    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_flight');
    }
}
