<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Change this line
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable // Change this line
{
    use HasFactory, Notifiable; // Ensure you include Notifiable trait

    protected $table = 'Users'; // Specify the table name if it doesn't follow Laravel's naming conventions

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'profile_image',
    ];

    protected $hidden = [
        'password', // Hide the password when retrieving the model
        'remember_token',
    ];

    // Add any additional methods or properties as needed
}
