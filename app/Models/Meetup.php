<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meetup extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'karting_name', 'place_id', 'meet_date', 'max_participants', 'description'];
    protected $casts = ['meet_date' => 'datetime'];

    // Organizador
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Pilotos apuntados
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }
}