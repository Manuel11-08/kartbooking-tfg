<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karting extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'city'];
}