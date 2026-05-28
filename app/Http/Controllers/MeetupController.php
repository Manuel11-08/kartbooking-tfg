<?php

namespace App\Http\Controllers;

use App\Models\Meetup;
use Illuminate\Http\Request;

class MeetupController extends Controller
{
    public function index()
    {
        // Muestra quedadas futuras
        $meetups = Meetup::with(['creator', 'participants'])
            ->where('meet_date', '>=', now())
            ->orderBy('meet_date')
            ->get();

        return view('meetups.index', compact('meetups'));
    }

    public function create()
    {
        return view('meetups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'karting_name' => 'required|string|max:255',
            'meet_date' => 'required|date|after:today',
            'max_participants' => 'required|integer|min:2|max:50',
            'description' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();

        $meetup = Meetup::create($validated);
        
        // El creador se une automáticamente
        $meetup->participants()->attach(auth()->id());

        return redirect()->route('meetups.index')->with('success', 'Tanda organizada con éxito.');
    }

    public function join(Meetup $meetup)
    {
        if ($meetup->participants()->count() >= $meetup->max_participants) {
            return back()->with('error', 'La parrilla está llena.');
        }

        if (!$meetup->hasParticipant(auth()->id())) {
            $meetup->participants()->attach(auth()->id());
        }

        return back()->with('success', 'Te has unido a la tanda.');
    }

    public function leave(Meetup $meetup)
    {
        $meetup->participants()->detach(auth()->id());
        return back()->with('success', 'Has abandonado la tanda.');
    }

    public function destroy(Meetup $meetup)
    {
        if (auth()->id() !== $meetup->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $meetup->delete();
        return back()->with('success', 'Tanda cancelada.');
    }
}