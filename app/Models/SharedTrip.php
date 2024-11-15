<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedTrip extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trip_id', 'status', 'new_trip'];

    // Define the relationships with other models, like Trip and User
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
