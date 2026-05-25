<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapTime extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'karting_name',
        'lap_time',
        'record_date',
    ];

    // Le decimos que este tiempo "pertenece a" un Usuario 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}