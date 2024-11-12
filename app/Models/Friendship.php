<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $table = 'friendships'; // Define the table name if it doesn't follow the plural convention
    protected $fillable = ['user_id', 'friend_id', 'status'];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }


    // Scope for active friendships
    public function scopeActive($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('friend_id', $userId);
        })
        ->where('status', 'accepted');
    }

    // Check if two users are friends
    public static function isFriend($userId, $friendId)
    {
        return self::where(function ($q) use ($userId, $friendId) {
            $q->where('user_id', $userId)
              ->where('friend_id', $friendId);
        })
        ->orWhere(function ($q) use ($userId, $friendId) {
            $q->where('user_id', $friendId)
              ->where('friend_id', $userId);
        })
        ->where('status', 'accepted')
        ->exists();
    }
}
