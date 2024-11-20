<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'name',
        'check_in',
        'check_out',
        'check_out_time',
        'cost',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
