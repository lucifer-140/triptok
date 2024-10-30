<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'details', 'cost'];

    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_transport');
    }
}
