<?php

namespace App\Http\Controllers;

use App\Models\LapTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapTimeController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'karting_name' => 'required|string|max:255',
            'lap_time' => 'required|string|max:15', 
            'record_date' => 'required|date',
        ]);

        
        Auth::user()->lapTimes()->create([
            'karting_name' => $request->karting_name,
            'lap_time' => $request->lap_time,
            'record_date' => $request->record_date,
        ]);

        
        return back()->with('success', '¡Crono registrado en la telemetría con éxito!');
    }
}