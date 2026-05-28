<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacto'); 
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        Mail::to('info.kartbooking@kartbooking.com')->send(new ContactMessage($datos));

        return redirect()->back()->with('success', 'Mensaje enviado a Dirección de Carrera con éxito.');
    }
}