<?php

// app/Models/Activity.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['day_id', 'title', 'start_time', 'end_time', 'estimated_budget', 'description'];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}

