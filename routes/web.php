<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KartingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LapTimeController;
use App\Models\Review;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\KartingController as AdminKartingController;

Route::get('/', function () {
    $reviews = Review::with('user')->latest()->take(6)->get();
    return view('welcome', compact('reviews'));
});

Route::get('/buscar-kartings', [KartingController::class, 'search'])->name('kartings.search');
Route::get('/kartings/detalles/{id}', [KartingController::class, 'show'])->name('kartings.show');

Route::get('/contacto', [ContactController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $lapTimes = auth()->user()->lapTimes()->latest()->get();
        return view('dashboard', compact('lapTimes'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/lap-times', [LapTimeController::class, 'store'])->name('lap-times.store');
    Route::put('/lap-times/{lapTime}', [LapTimeController::class, 'update'])->name('lap-times.update');
    Route::delete('/lap-times/{lapTime}', [LapTimeController::class, 'destroy'])->name('lap-times.destroy');
    
    Route::get('/mis-resenas', [ReviewController::class, 'myReviews'])->name('mis-resenas');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/user/{review}', [ReviewController::class, 'userDestroy'])->name('reviews.userDestroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle');

    Route::get('/kartings', [AdminKartingController::class, 'index'])->name('kartings.index');
    Route::get('/kartings/create', [AdminKartingController::class, 'create'])->name('kartings.create');
    Route::post('/kartings', [AdminKartingController::class, 'store'])->name('kartings.store');
    Route::get('/kartings/{karting}/edit', [AdminKartingController::class, 'edit'])->name('kartings.edit');
    Route::put('/kartings/{karting}', [AdminKartingController::class, 'update'])->name('kartings.update');
    Route::delete('/kartings/{karting}', [AdminKartingController::class, 'destroy'])->name('kartings.destroy');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});