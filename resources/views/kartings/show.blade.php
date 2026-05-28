<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Detalles del Circuito</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">

    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <a href="{{ route('kartings.search') }}" class="text-sm font-bold text-gray-300 hover:text-white uppercase"> Volver al Radar</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-12">
        
        <div class="bg-black border border-zinc-800 rounded-xl overflow-hidden shadow-2xl mb-12">
            <div class="h-96 bg-zinc-900 relative">
                @if(isset($karting['photos']) && count($karting['photos']) > 0)
                    <img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=1200&photoreference={{ $karting['photos'][0]['photo_reference'] }}&key={{ env('GOOGLE_PLACES_API_KEY') }}" class="w-full h-full object-cover">
                @endif
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-8">
                    <h1 class="text-5xl font-black uppercase text-white mb-2">{{ $karting['name'] }}</h1>
                    <p class="text-gray-300 font-mono text-sm">{{ $karting['formatted_address'] }}</p>
                </div>
            </div>

            <div class="p-8 flex justify-between items-center bg-zinc-900 border-t border-zinc-800">
                <div class="flex items-center gap-4">
                    <span class="text-kartred font-black text-3xl">{{ $karting['rating'] ?? 'N/A' }} / 5</span>
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Valoración General</span>
                </div>
                <a href="{{ $karting['url'] ?? '#' }}" target="_blank" class="bg-kartred hover:bg-red-700 text-white font-black px-8 py-3 rounded uppercase transition tracking-wider shadow-lg">
                    Trazar Ruta en Maps
                </a>
            </div>
        </div>

        <h2 class="text-2xl font-black uppercase mb-8 border-l-8 border-kartred pl-4 text-white">Telemetría de Pilotos (Reseñas Reales)</h2>

        <div class="space-y-6">
            @if(isset($karting['reviews']) && count($karting['reviews']) > 0)
                @foreach($karting['reviews'] as $review)
                <div class="bg-black border border-zinc-800 p-6 rounded-lg shadow-xl">
                    <div class="flex items-center justify-between mb-4 border-b border-zinc-900 pb-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $review['profile_photo_url'] }}" class="w-10 h-10 rounded-full border border-zinc-700">
                            <div>
                                <h4 class="font-bold text-white uppercase">{{ $review['author_name'] }}</h4>
                                <span class="text-xs text-gray-500 font-mono">{{ $review['relative_time_description'] }}</span>
                            </div>
                        </div>
                        <div class="bg-zinc-900 px-3 py-1 rounded border border-zinc-800 text-kartred font-black">
                            {{ $review['rating'] }} / 5
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $review['text'] }}</p>
                </div>
                @endforeach
            @else
                <div class="bg-zinc-900 border border-zinc-800 p-8 rounded text-center text-gray-500 uppercase font-bold text-sm">
                    No hay reseñas registradas para este circuito.
                </div>
            @endif
        </div>

    </main>
</body>
</html>