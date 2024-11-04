<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'type',
        'date',
        'departure_time',
        'arrival_time',
        'cost',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
