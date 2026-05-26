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

                // Calculamos distancia real y descartamos los que se salen del radio
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

            // Ordenamos por distancia de menor a mayor
            usort($kartings, function($a, $b) {
                return $a['distancia_real'] <=> $b['distancia_real'];
            });

        } elseif ($locationName) {
            // Si no hay coordenadas buscamos directamente por nombre de ciudad
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

        return view('kartings.search', compact('kartings', 'locationName', 'radio'));
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

    public function show($id)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $id,
            'fields' => 'name,rating,reviews,formatted_address,photos,url',
            'key' => env('GOOGLE_PLACES_API_KEY'),
            'language' => 'es'
        ]);

        $karting = $response->json()['result'] ?? null;

        if (!$karting) {
            return redirect()->route('kartings.search')->with('error', 'No se encontró el circuito');
        }

        return view('kartings.show', compact('karting'));
    }
}