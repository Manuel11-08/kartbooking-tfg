<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KartingController;
use App\Http\Controllers\LapTimeController; 
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KartingController as AdminKartingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buscar-kartings', [KartingController::class, 'search'])->name('kartings.search');
Route::get('/karting/{id}/detalles', [KartingController::class, 'show'])->name('kartings.show');
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');



// Ruta del Box (Ahora carga el historial de tiempos)
Route::get('/dashboard', function () {
    $lapTimes = Auth::user()->lapTimes()->orderBy('record_date', 'desc')->get();
    return view('dashboard', compact('lapTimes'));
})->middleware(['auth', 'verified'])->name('dashboard');

// NUEVO: Ruta para guardar un nuevo crono en la base de datos
Route::post('/lap-times', [LapTimeController::class, 'store'])
    ->middleware('auth')
    ->name('lap-times.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Panel principal (Dashboard)
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // Gestión de Usuarios (CRUD)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle');

    // Gestión de Circuitos Locales (CRUD)
    Route::get('/kartings', [AdminKartingController::class, 'index'])->name('kartings.index'); 
    Route::get('/kartings/create', [AdminKartingController::class, 'create'])->name('kartings.create');
    Route::post('/kartings', [AdminKartingController::class, 'store'])->name('kartings.store');
    Route::delete('/kartings/{karting}', [AdminKartingController::class, 'destroy'])->name('kartings.destroy'); 
});