<?php

// app/Models/Accommodation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = ['day_id', 'name', 'check_in_date', 'check_out_date', 'cost'];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
