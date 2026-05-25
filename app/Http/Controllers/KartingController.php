<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Karting; 

class KartingController extends Controller
{
    public function search(Request $request)
    {
        set_time_limit(120);

        if (!$request->has('lat') || !$request->has('lon')) {
            return view('kartings.search', ['kartings' => []]);
        }

        $lat = (float) $request->input('lat');
        $lon = (float) $request->input('lon');
        $radius = (int) $request->input('radius', 20000); 

        
        $query = "[out:json][timeout:90];
        (
          nwr(around:{$radius},{$lat},{$lon})['sport'='karting'];
          nwr(around:{$radius},{$lat},{$lon})['sport'='motor']['motor_sport'='karting'];
          nwr(around:{$radius},{$lat},{$lon})['karting'='yes'];
          nwr(around:{$radius},{$lat},{$lon})['name'~'(^| )[Kk]art'];
          nwr(around:{$radius},{$lat},{$lon})['name'~'KR24'];
        );
        out center;";

        $response = Http::withoutVerifying()
                        ->timeout(90)
                        ->asForm()
                        ->withHeaders([
                            'User-Agent' => 'Kartbooking TFG Project (Student)',
                            'Accept' => '*/*'
                        ])
                        ->post('https://overpass-api.de/api/interpreter', [
                            'data' => $query
                        ]);

        $apiKartings = $response->json('elements') ?? [];

      
        $localKartingsRaw = Karting::all();
        $localKartings = [];

        foreach ($localKartingsRaw as $local) {
           
            $dist = $this->getDistance($lat, $lon, $local->latitude, $local->longitude);
            
           
            if ($dist <= ($radius / 1000)) {
                $localKartings[] = [
                    'id' => 'local_' . $local->id,
                    'lat' => $local->latitude,
                    'lon' => $local->longitude,
                    'tags' => [
                        'name' => $local->name . ' (Local)',
                    ]
                ];
            }
        }

       
        $allResults = collect(array_merge($apiKartings, $localKartings));

        $kartings = $allResults
            ->filter(function ($item) {
                if (!isset($item['tags']['name'])) return false;
                $name = strtolower($item['tags']['name']);
                $forbidden = ['melkart', 'dios', 'restaurante', 'bar', 'hotel', 'asociación', 'calle', 'avenida', 'automodelismo'];
                foreach ($forbidden as $word) {
                    if (str_contains($name, $word)) return false;
                }
                return true;
            })
            ->unique(function ($item) {
                return $item['tags']['name'];
            })
            ->values()
            ->toArray();

        return view('kartings.search', compact('kartings', 'lat', 'lon', 'radius'));
    }

  
    private function getDistance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344); //Para que te de en km
    }

    public function show(Request $request)
    {
        $name = $request->query('name', 'Circuito Desconocido');
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        return view('kartings.show', compact('name', 'lat', 'lon'));
    }
}