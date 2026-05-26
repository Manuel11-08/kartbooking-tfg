<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Radar GPS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">

    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-300 hover:text-white uppercase">Volver al Box</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-black uppercase mb-8 border-l-8 border-kartred pl-4">Radar Satélite</h1>

        <form id="searchForm" action="{{ route('kartings.search') }}" method="GET" class="bg-black border border-zinc-800 p-6 rounded-xl mb-12 shadow-2xl">
            <div class="flex flex-col md:flex-row gap-4">
                
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">

                <div class="flex-1 flex flex-col md:flex-row gap-4">
                    <button type="button" onclick="obtenerUbicacion()" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold px-6 py-4 rounded uppercase text-sm transition border border-zinc-700 whitespace-nowrap">
                        Usar mi ubicación GPS
                    </button>
                    <span class="flex items-center justify-center text-gray-500 font-bold uppercase text-sm">- O -</span>
                    <input type="text" name="location" id="location" value="{{ $locationName ?? '' }}" placeholder="Ciudad manual" class="flex-1 bg-zinc-900 border border-zinc-700 rounded p-4 text-white focus:border-kartred outline-none transition uppercase text-sm font-bold">
                </div>

                <select name="radius" class="bg-zinc-900 border border-zinc-700 rounded p-4 text-white uppercase font-bold text-sm outline-none focus:border-kartred">
                    <option value="10" {{ (isset($radius) && $radius == 10) ? 'selected' : '' }}>Radio: 10 KM</option>
                    <option value="20" {{ (isset($radius) && $radius == 20) || !isset($radius) ? 'selected' : '' }}>Radio: 20 KM</option>
                    <option value="50" {{ (isset($radius) && $radius == 50) ? 'selected' : '' }}>Radio: 50 KM</option>
                    <option value="100" {{ (isset($radius) && $radius == 100) ? 'selected' : '' }}>Radio: 100 KM</option>
                </select>

                <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-black px-8 py-4 rounded uppercase transition tracking-wider">
                    Escanear
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($kartings as $karting)
            <div class="bg-black border border-zinc-800 rounded-xl overflow-hidden shadow-2xl hover:border-kartred transition duration-300 flex flex-col relative">
                
                <div class="absolute top-4 right-4 bg-kartred text-white text-xs font-black uppercase px-3 py-1 rounded shadow-lg z-20 tracking-widest">
                    {{ $karting['distancia_real'] }} KM
                </div>

                <div class="h-64 bg-zinc-900 relative">
                    @if(isset($karting['photos']) && count($karting['photos']) > 0)
                        <img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={{ $karting['photos'][0]['photo_reference'] }}&key={{ env('GOOGLE_PLACES_API_KEY') }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-zinc-700 font-bold uppercase text-xs tracking-widest">Sin señal de cámara</div>
                    @endif
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-black uppercase text-white mb-2">{{ $karting['name'] }}</h3>
                        <p class="text-gray-400 text-sm mb-4 h-10 overflow-hidden">{{ $karting['formatted_address'] ?? $karting['vicinity'] ?? 'Dirección no disponible' }}</p>
                        
                        @if(isset($karting['rating']))
                            <div class="flex items-center gap-3 mb-4 bg-zinc-900 w-fit px-4 py-2 rounded border border-zinc-800">
                                <span class="text-kartred font-black text-xl">{{ $karting['rating'] }} / 5</span>
                                <div class="w-px h-6 bg-zinc-700"></div>
                                <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">{{ $karting['user_ratings_total'] ?? 0 }} Reseñas</span>
                            </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('kartings.show', $karting['place_id']) }}" class="block w-full text-center border border-kartred text-kartred hover:bg-kartred hover:text-white font-black py-3 rounded uppercase text-sm transition mt-4">
                        Ver Detalles y Reseñas ->
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 bg-zinc-900 border border-zinc-800 p-12 rounded-xl text-center">
                <p class="text-gray-400 font-bold uppercase tracking-widest">No se han detectado circuitos en este radio.</p>
            </div>
            @endforelse
        </div>
    </main>

    <script>
        function obtenerUbicacion() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lng').value = position.coords.longitude;
                    document.getElementById('location').value = '';
                    document.getElementById('searchForm').submit();
                }, function(error) {
                    alert('Error al acceder al GPS. Asegúrate de dar permisos en tu navegador.');
                });
            } else {
                alert('Tu navegador no soporta geolocalización.');
            }
        }
    </script>
</body>
</html>