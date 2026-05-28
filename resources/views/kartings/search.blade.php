<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white min-h-screen flex flex-col">

  <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center w-full">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic hover:text-white transition">
                KARTBOOKING
            </a>
            
            <div class="flex justify-end items-center gap-6">
                <a href="/" class="text-sm font-bold text-gray-300 hover:text-kartred uppercase transition tracking-wider">Inicio</a>
                <a href="{{ route('contacto') }}" class="text-sm font-bold text-gray-300 hover:text-kartred uppercase transition tracking-wider">Contacto</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-300 hover:text-white uppercase transition tracking-wider">Mi Box</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto px-6 py-10 w-full">

        
        <div class="bg-black border border-zinc-800 rounded-2xl p-8 md:p-12 text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-black uppercase text-white mb-4">
                Encuentra tu <span class="text-kartred">Karting.</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto mb-8">
                Busca kartings cerca de tu ubicación o introduce una ciudad.
            </p>

            <form id="searchForm" action="{{ route('kartings.search') }}" method="GET" class="max-w-3xl mx-auto">
                <div class="flex flex-col md:flex-row gap-3">

                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">

                    <button type="button" onclick="obtenerUbicacion()" id="btnGps" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold px-6 py-3 rounded-lg uppercase text-sm border border-zinc-700">
                        Usar mi ubicación
                    </button>

                    <input
                        type="text"
                        name="location"
                        id="location"
                        value="{{ $locationName ?? '' }}"
                        placeholder="Ej: Madrid"
                        class="flex-1 bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-kartred outline-none placeholder-zinc-500"
                    >

                    <select name="radius" class="bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white outline-none focus:border-kartred">
                        <option value="10" {{ (isset($radius) && $radius == 10) ? 'selected' : '' }}>10 km</option>
                        <option value="20" {{ (isset($radius) && $radius == 20) || !isset($radius) ? 'selected' : '' }}>20 km</option>
                        <option value="50" {{ (isset($radius) && $radius == 50) ? 'selected' : '' }}>50 km</option>
                        <option value="100" {{ (isset($radius) && $radius == 100) ? 'selected' : '' }}>100 km</option>
                    </select>

                    <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-black px-8 py-3 rounded-lg uppercase text-sm transition">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
@if(isset($weather))
            <div class="bg-black border border-zinc-800 rounded-xl p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-kartred font-black uppercase tracking-widest text-xs mb-1">Meteorología de la zona</h3>
                    <p class="text-white text-2xl font-black uppercase">{{ $weather['temp'] }}C - {{ $weather['desc'] }}</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">Viento en pista</p>
                    <p class="text-white font-mono">{{ $weather['wind'] }} km/h</p>
                </div>
            </div>
        @endif

        @if(isset($kartings) && count($kartings) > 0)
            <h2 class="text-xl font-black uppercase text-white mb-6">Resultados ({{ count($kartings) }})</h2>
        @elseif(isset($locationName) || (isset($lat) && isset($lng)))
            <h2 class="text-xl font-black uppercase text-gray-500 mb-6">No se han encontrado resultados</h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($kartings as $karting)
            <div class="bg-black border border-zinc-800 rounded-xl overflow-hidden hover:border-kartred transition flex flex-col relative group">

                <div class="absolute top-3 right-3 bg-kartred text-white text-xs font-bold px-3 py-1 rounded z-20">
                    {{ $karting['distancia_real'] ?? 'N/A' }} km
                </div>

                <div class="h-52 bg-zinc-900 relative overflow-hidden">
                    @if(isset($karting['photos']) && count($karting['photos']) > 0)
                        <img
                            src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={{ $karting['photos'][0]['photo_reference'] }}&key={{ env('GOOGLE_PLACES_API_KEY') }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            alt="Foto de {{ $karting['name'] }}"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center text-zinc-600">
                            <span class="text-xs uppercase font-bold tracking-widest">Sin imagen</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between -mt-10 relative z-10">
                    <div>
                        <h3 class="text-xl font-black uppercase text-white mb-1 line-clamp-1">{{ $karting['name'] }}</h3>
                        <p class="text-gray-400 text-sm mb-3 line-clamp-1">{{ $karting['formatted_address'] ?? $karting['vicinity'] ?? 'Dirección no disponible' }}</p>

                        @if(isset($karting['rating']))
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-kartred font-bold text-sm">{{ $karting['rating'] }}/5</span>
                            <span class="text-gray-500 text-xs uppercase font-bold">({{ $karting['user_ratings_total'] ?? 0 }} reseñas)</span>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('kartings.show', ['name' => $karting['name'], 'lat' => $karting['geometry']['location']['lat'] ?? 0, 'lon' => $karting['geometry']['location']['lng'] ?? 0]) }}" class="block w-full text-center border border-zinc-700 hover:border-kartred hover:bg-kartred text-white font-bold py-3 rounded-lg uppercase text-sm transition mt-3">
                        Ver detalles
                    </a>
                </div>
            </div>
            @empty
                @if(isset($locationName) || (isset($lat) && isset($lng)))
                <div class="col-span-2 bg-zinc-900 border border-zinc-800 p-12 rounded-xl text-center">
                    <p class="text-gray-400 font-bold uppercase text-sm mb-2">No hay kartings en esta zona.</p>
                    <p class="text-zinc-500 text-sm">Prueba a ampliar el radio o buscar en otra ciudad.</p>
                </div>
                @endif
            @endforelse
        </div>

    </main>

    <script>
        // Boton GPS - pide la ubicacion y manda el formulario
        function obtenerUbicacion() {
            if (!navigator.geolocation) {
                alert('Tu navegador no soporta geolocalización.');
                return;
            }

            var btn = document.getElementById('btnGps');
            btn.textContent = 'Buscando...';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(function(pos) {
                document.getElementById('lat').value = pos.coords.latitude;
                document.getElementById('lng').value = pos.coords.longitude;
                document.getElementById('location').value = '';
                document.getElementById('searchForm').submit();
            }, function() {
                alert('No se pudo obtener la ubicación. Revisa los permisos del navegador.');
                btn.textContent = 'Usar mi ubicación';
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>