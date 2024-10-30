<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location'];

    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_activity');
    }
}
