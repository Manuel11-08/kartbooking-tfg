<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LapTime;

class LapTimeController extends Controller
{
  public function store(Request $request)
    {
        $validated = $request->validate([
            'karting_name' => 'required|string|max:255',
            'lap_time' => 'required|string|max:20',
            'record_date' => 'required|date',
        ]);

        $request->user()->lapTimes()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Crono registrado en la telemetría.');
    }

    public function update(Request $request, LapTime $lapTime)
    {
        if ($lapTime->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'karting_name' => 'required|string|max:255',
            'lap_time' => 'required|string|max:20',
            'record_date' => 'required|date',
        ]);

        $lapTime->update($validated);

        return redirect()->route('dashboard')->with('success', 'Crono actualizado correctamente.');
    }

    public function destroy(Request $request, LapTime $lapTime)
    {
        if ($lapTime->user_id !== $request->user()->id) {
            abort(403);
        }

        $lapTime->delete();

        return redirect()->route('dashboard')->with('success', 'Crono eliminado de la base de datos.');
    }
}