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
        $radius = (int) $request->input('radius', 20);

        if ($locationName && (!$lat || !$lng)) {
            $geoResponse = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => $locationName,
                'key' => env('GOOGLE_PLACES_API_KEY'),
                'language' => 'es'
            ]);
            
            $geoResult = $geoResponse->json()['results'][0] ?? null;
            if ($geoResult) {
                $lat = $geoResult['geometry']['location']['lat'];
                $lng = $geoResult['geometry']['location']['lng'];
            }
        }

        $kartings = [];

        if ($lat && $lng) {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => 'karting',
                'location' => $lat . ',' . $lng,
                'radius' => $radius * 1000,
                'key' => env('GOOGLE_PLACES_API_KEY'),
                'language' => 'es'
            ]);
            
            $resultados = $response->json()['results'] ?? [];
            
            foreach ($resultados as $k) {
                $nombre = strtolower($k['name']);
                
               
                if (!str_contains($nombre, 'kart') && !str_contains($nombre, 'circuito') && !str_contains($nombre, 'motor') && !str_contains($nombre, 'speed')) {
                    continue; 
                }

               
                $palabrasProhibidas = ['humor amarillo', 'action live', 'paintball', 'laser', 'escape', 'trampoline', 'bolera', 'spa', 'shopping'];
                $esValido = true;
                foreach ($palabrasProhibidas as $palabra) {
                    if (str_contains($nombre, $palabra)) {
                        $esValido = false;
                        break;
                    }
                }
                if (!$esValido) continue;

                
                if (isset($k['geometry']['location'])) {
                    $placeLat = $k['geometry']['location']['lat'];
                    $placeLng = $k['geometry']['location']['lng'];
                    
                    $distanciaKm = $this->calcularDistancia($lat, $lng, $placeLat, $placeLng);
                    
                    if ($distanciaKm <= $radius) {
                        $k['distancia_real'] = round($distanciaKm, 1);
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

        return view('kartings.search', compact('kartings', 'locationName', 'radius'));
    }

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
            return redirect()->route('kartings.search')->with('error', 'Circuito no encontrado');
        }

        return view('kartings.show', compact('karting'));
    }
}