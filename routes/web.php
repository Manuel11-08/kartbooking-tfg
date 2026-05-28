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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    $reviews = Review::with('user')->latest()->take(6)->get();
    $featuredKartings = [];
    $apiKey = env('GOOGLE_PLACES_API_KEY');

    if ($apiKey) {
        $fallbackData = [
            'ChIJT_x_g5xwQQ0RjE6qV8mK15s' => [
                'image_url' => 'https://images.unsplash.com/photo-1546592033-9118c772c9e7?auto=format&fit=crop&w=800&q=80',
                'formatted_address' => 'C. Sepúlveda, 3, Madrid',
                'lat' => 40.4082,
                'lon' => -3.7339,
            ],
            'ChIJ-b-8rRnmDQ0RUxKz8bB9b1Y' => [
                'image_url' => 'https://images.unsplash.com/photo-1596703960012-68045617a233?auto=format&fit=crop&w=800&q=80',
                'formatted_address' => 'Ctra. A-384, Campillos',
                'lat' => 36.9631,
                'lon' => -4.8329,
            ],
            'ChIJ08-fT6iVWQ0RPz_fT-v1B8Q' => [
                'image_url' => 'https://images.unsplash.com/photo-1601597112366-7fb2513d2970?auto=format&fit=crop&w=800&q=80',
                'formatted_address' => 'Ctra. TE-V-7033, Alcañiz',
                'lat' => 41.0772,
                'lon' => -0.2045,
            ],
        ];

        $placeIds = array_keys($fallbackData);

        foreach ($placeIds as $id) {
            try {
              
                $data = Cache::remember('portada_limpia_' . $id, 86400, function () use ($id, $apiKey, $fallbackData) {
                    $response = Http::withoutVerifying()->timeout(5)->get('https://maps.googleapis.com/maps/api/place/details/json', [
                        'place_id' => $id,
                        'fields' => 'name,rating,formatted_address,photos,geometry',
                        'key' => $apiKey,
                        'language' => 'es'
                    ]);

                    $body = $response->json();
                    $result = $body['result'] ?? null;

                    if ($response->ok() && isset($body['status']) && $body['status'] === 'OK' && $result) {
                        if (isset($result['photos'][0]['photo_reference'])) {
                            $result['image_url'] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=" . $result['photos'][0]['photo_reference'] . "&key=" . $apiKey;
                        } else {
                            $result['image_url'] = $fallbackData[$id]['image_url'];
                        }

                        $result['lat'] = $result['geometry']['location']['lat'] ?? $fallbackData[$id]['lat'];
                        $result['lon'] = $result['geometry']['location']['lng'] ?? $fallbackData[$id]['lon'];
                        $result['formatted_address'] = $result['formatted_address'] ?? $fallbackData[$id]['formatted_address'];

                        return $result;
                    }
                    return null;
                });

                if ($data && isset($data['lat']) && isset($data['lon'])) {
                    $featuredKartings[] = $data;
                }
            } catch (\Exception $e) {
            }
        }
    }

    if (empty($featuredKartings)) {
        $featuredKartings = [
            [
                'name' => 'Karting Carlos Sainz Center',
                'formatted_address' => 'C. Sepúlveda, 3, Madrid',
                'rating' => 4.6,
                'image_url' => 'https://lh3.googleusercontent.com/p/AF1QipMCcZXgxF3RfzKIvgEsRo-NHAcsMTR3j5Q6F_nb=s680-w680-h510-rw',
                'lat' => 40.4082,
                'lon' => -3.7339
            ],
            [
                'name' => 'KartCenter Campillos',
                'formatted_address' => 'Ctra. A-384, Campillos',
                'rating' => 4.8,
                'image_url' => 'https://lh3.googleusercontent.com/gps-cs-s/APNQkAGQYahmAC4a-JG5rrZltQpYIqWlSS9-9mLKpIiYHGqR8j4GEdE1uQoY8-nbziTnP3clCeErTCpd-AhJ0FevxJ3F5GIIP-TDV482Yt93QmF_nrds8ZAHJEySe1Np-UlNbtVRrhTD=s680-w680-h510-rw',
                'lat' => 36.9631,
                'lon' => -4.8329
            ],
            [
                'name' => 'Karting Motorland Aragón',
                'formatted_address' => 'Ctra. TE-V-7033, Alcañiz',
                'rating' => 4.9,
                'image_url' => 'https://lh3.googleusercontent.com/gps-cs-s/APNQkAH9YX6KNhWxx2VsiytTUybozcWukYPsTcWRYvaPybF4RlwFVr9u4nBmQgo77rY865ofnt7SCUEg8molryXC70LiVUYFrZ-cW_26yHkeE_64-jLsQqRbpUHZIKHO6DldpHZ7MBVBKg=s680-w680-h510-rw',
                'lat' => 41.0772,
                'lon' => -0.2045
            ]
        ];
    }

    return view('welcome', compact('reviews', 'featuredKartings'));
});

Route::get('/buscar-kartings', [KartingController::class, 'search'])->name('kartings.search');
Route::get('/kartings/detalles/{name}/{lat}/{lon}', [KartingController::class, 'show'])->name('kartings.show');

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