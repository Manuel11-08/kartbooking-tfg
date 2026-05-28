<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar la tabla de usuarios 
    public function index()
    {
        
        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('admin.users.index', compact('users'));
    }

    
    public function toggleAdmin(User $user)
    {
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back()->with('success', 'Rango de permisos actualizado con éxito.');
    }

    // Eliminar a un usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Piloto expulsado del sistema.');
    }
}