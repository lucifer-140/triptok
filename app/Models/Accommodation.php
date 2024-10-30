<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'cost'];

    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_accommodation');
    }
}
