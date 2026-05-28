<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karting;
use Illuminate\Http\Request;

class KartingController extends Controller
{
    // Mostrar la lista de circuitos locales
    public function index()
    {
        $kartings = Karting::all();
        return view('admin.kartings.index', compact('kartings'));
    }

    // Mostrar el formulario para añadir nuevos
    public function create()
    {
        return view('admin.kartings.create');
    }

    // Guardar el circuito en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Karting::create($request->all());

        
        return redirect()->route('admin.kartings.index')->with('success', '¡Circuito ' . $request->name . ' añadido a la parrilla local!');
    }

    // Mostrar el formulario de edición
    public function edit(Karting $karting)
    {
        return view('admin.kartings.edit', compact('karting'));
    }

    // Guardar los cambios actualizados
    public function update(Request $request, Karting $karting)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $karting->update($request->all());

        return redirect()->route('admin.kartings.index')->with('success', 'Circuito actualizado en la base de datos.');
    }
    
    // Eliminar un circuito
    public function destroy(Karting $karting)
    {
        $karting->delete();
        return redirect()->route('admin.kartings.index')->with('success', 'Circuito eliminado de la base de datos.');
    }
}