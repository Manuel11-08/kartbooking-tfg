<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KartingController extends Controller
{
  public function search(Request $request)
    {
        $locationName = $request->input('location');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radio = (int) $request->input('radius', 20);

        if ($locationName && (!$lat || !$lng)) {
            $geoResponse = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => $locationName,
                'key' => env('GOOGLE_PLACES_API_KEY'),
                'language' => 'es'
            ]);

            $primerResultado = $geoResponse->json()['results'][0] ?? null;
            if ($primerResultado) {
                $lat = $primerResultado['geometry']['location']['lat'];
                $lng = $primerResultado['geometry']['location']['lng'];
            }
        }

       
        $weather = null;
        if ($lat && $lng) {
            try {
                $weatherResponse = Http::timeout(3)->get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current_weather' => true
                ]);

                if ($weatherResponse->ok()) {
                    $data = $weatherResponse->json()['current_weather'] ?? null;
                    if ($data) {
                        $code = $data['weathercode'];
                        $desc = 'Despejado';
                        if (in_array($code, [1, 2, 3])) $desc = 'Nublado';
                        if (in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82])) $desc = 'Lluvia / Pista Mojada';
                        if (in_array($code, [71, 73, 75, 77, 85, 86])) $desc = 'Nieve / Hielo';
                        if (in_array($code, [95, 96, 99])) $desc = 'Tormenta Eléctrica';

                        $weather = [
                            'temp' => $data['temperature'],
                            'wind' => $data['windspeed'],
                            'desc' => $desc
                        ];
                    }
                }
            } catch (\Exception $e) {}
        }

        $kartings = [];

        if ($lat && $lng) {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => 'karting',
                'location' => $lat . ',' . $lng,
                'radius' => $radio * 1000,
                'key' => env('GOOGLE_PLACES_API_KEY'),
                'language' => 'es'
            ]);

            $resultados = $response->json()['results'] ?? [];

            foreach ($resultados as $k) {
                $nombre = strtolower($k['name']);

                if (!str_contains($nombre, 'kart') && !str_contains($nombre, 'circuito') && !str_contains($nombre, 'motor') && !str_contains($nombre, 'speed')) {
                    continue;
                }

                $excluir = ['paintball', 'laser', 'escape', 'trampoline', 'bolera', 'spa', 'shopping', 'humor amarillo', 'action live'];
                $valido = true;
                foreach ($excluir as $palabra) {
                    if (str_contains($nombre, $palabra)) {
                        $valido = false;
                        break;
                    }
                }
                if (!$valido) continue;

                if (isset($k['geometry']['location'])) {
                    $placeLat = $k['geometry']['location']['lat'];
                    $placeLng = $k['geometry']['location']['lng'];
                    $distancia = $this->calcularDistancia($lat, $lng, $placeLat, $placeLng);

                    if ($distancia <= $radio) {
                        $k['distancia_real'] = round($distancia, 1);
                        $kartings[] = $k;
                    }
                }
            }

            usort($kartings, function($a, $b) {
                return $a['distancia_real'] <=> $b['distancia_real'];
            });

        } elseif ($locationName) {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => 'circuito karting en ' . $locationName,
                'key' => env('GOOGLE_PLACES_API_KEY'),
                'language' => 'es'
            ]);

            $resultados = $response->json()['results'] ?? [];
            foreach ($resultados as $k) {
                $nombre = strtolower($k['name']);
                if (!str_contains($nombre, 'kart') && !str_contains($nombre, 'circuito') && !str_contains($nombre, 'motor')) {
                    continue;
                }
                $kartings[] = $k;
            }
        }

        // Pasamos la variable $weather a la vista
        return view('kartings.search', compact('kartings', 'locationName', 'radio', 'weather'));
    }

    // Formula para calcular distancia entre dos coordenadas en km
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        return ($dist * 60 * 1.1515 * 1.609344);
    }

    public function show($name, $lat = null, $lon = null)
    {
        $karting = null;
        $placeId = null;

        if ($lat !== null && $lon !== null) {
            try {
                $searchResponse = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                    'query' => $name,
                    'location' => $lat . ',' . $lon,
                    'radius' => 5000,
                    'key' => env('GOOGLE_PLACES_API_KEY'),
                    'language' => 'es'
                ]);

                $results = $searchResponse->json()['results'] ?? [];
                $first = $results[0] ?? null;

                if ($first && isset($first['place_id'])) {
                    $placeId = $first['place_id'];
                }
            } catch (\Exception $e) {
                
            }
        } else {
            $placeId = $name;
        }

        if ($placeId) {
            try {
                $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields' => 'name,rating,reviews,formatted_address,photos,url,geometry',
                    'key' => env('GOOGLE_PLACES_API_KEY'),
                    'language' => 'es'
                ]);

                $karting = $response->json()['result'] ?? null;
            } catch (\Exception $e) {
                $karting = null;
            }
        }

        
        if ($karting && !isset($karting['photos'])) {
            $karting['image_url'] = 'https://images.unsplash.com/photo-1601597112366-7fb2513d2970?auto=format&fit=crop&w=1200&q=80';
        }

       
        if (!$karting) {
            $karting = [
                'name' => $name,
                'formatted_address' => $lat && $lon ? 'Coordenadas: ' . $lat . ', ' . $lon : 'Dirección no disponible',
                'rating' => null,
                'photos' => [],
                'reviews' => [],
                'url' => $lat && $lon ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($lat . ',' . $lon) : '#',
                'image_url' => 'https://images.unsplash.com/photo-1601597112366-7fb2513d2970?auto=format&fit=crop&w=1200&q=80',
                'lat' => $lat,
                'lon' => $lon,
            ];
        }

        return view('kartings.show', compact('karting'));
    }
}