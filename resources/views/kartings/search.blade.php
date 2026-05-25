<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Buscar Kartings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-kartblack text-white antialiased selection:bg-kartred selection:text-white">

    <nav class="border-b border-kartred/30 bg-black/50 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase">
                KARTBOOKING
            </a>
            <div class="space-x-6 text-sm font-semibold text-gray-300">
                <a href="/" class="hover:text-kartred transition">Inicio</a>
                <a href="{{ route('kartings.search') }}" class="text-kartred border-b-2 border-kartred pb-1">Buscar Kartings</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-8 text-center uppercase tracking-tight">
            Circuitos en tu <span class="text-kartred">Zona</span>
        </h1>

        <form id="searchForm" action="{{ route('kartings.search') }}" method="GET" class="text-center mb-16">
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lon" id="lon">

            <div class="flex justify-center items-center gap-4 mb-8">
                <label for="radius" class="text-gray-400 font-semibold uppercase tracking-wide text-sm">Radio de búsqueda:</label>
                <select name="radius" id="radius" style="background-color: white; color: black;" class="rounded p-2 outline-none transition cursor-pointer font-bold">
                    <option value="10000" {{ request('radius') == '10000' ? 'selected' : '' }}>10 Kilómetros</option>
                    <option value="20000" {{ request('radius') == '20000' || !request('radius') ? 'selected' : '' }}>20 Kilómetros</option>
                    <option value="50000" {{ request('radius') == '50000' ? 'selected' : '' }}>50 Kilómetros</option>
                    <option value="100000" {{ request('radius') == '100000' ? 'selected' : '' }}>100 Kilómetros</option>
                    <option value="200000" {{ request('radius') == '200000' ? 'selected' : '' }}>200 Kilómetros</option>
                </select>
            </div>

            <button type="button" onclick="getLocation()" class="inline-block px-8 py-4 text-lg font-bold bg-kartred text-white rounded hover:bg-red-700 transition transform hover:scale-105 shadow-[0_0_15px_rgba(230,0,0,0.5)] uppercase tracking-wide cursor-pointer">
                 Buscar circuitos
            </button>
            <p id="statusMessage" class="text-gray-400 mt-4 text-sm h-5"></p>
        </form>

        @if(isset($lat) && isset($lon))
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-kartred pl-3 uppercase tracking-wide">
                Resultados a {{ $radius / 1000 }} km
            </h2>
            
            @if(count($kartings) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kartings as $karting)
                        <div class="bg-zinc-900 border border-zinc-800 hover:border-kartred transition p-6 rounded-lg relative overflow-hidden group flex flex-col justify-between">
                            <div class="absolute top-0 left-0 w-1 h-full bg-kartred transform -translate-x-full group-hover:translate-x-0 transition"></div>
                            
                            <div>
                                @php
                                    $itemLat = $karting['lat'] ?? $karting['center']['lat'] ?? 0;
                                    $itemLon = $karting['lon'] ?? $karting['center']['lon'] ?? 0;
                                    $kartName = $karting['tags']['name'] ?? 'Circuito sin nombre registrado';
                                @endphp
                                
                                <h3 class="text-xl font-bold mb-2 text-white">
                                    {{ $kartName }}
                                </h3>
                                <p class="text-gray-400 text-sm mb-6">
                                     Lat: {{ number_format($itemLat, 4) }} <br>
                                     Lon: {{ number_format($itemLon, 4) }}
                                </p>
                            </div>
                            
                            <a href="{{ route('kartings.show', ['name' => $kartName, 'lat' => $itemLat, 'lon' => $itemLon]) }}" 
                               class="block w-full text-center py-2 border border-kartred text-kartred font-semibold hover:bg-kartred hover:text-white transition uppercase text-sm rounded">
                                Ver detalles
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-zinc-900 p-10 rounded-lg text-center border border-zinc-800">
                    <p class="text-gray-400 text-lg">No hemos encontrado instalaciones de karting a {{ $radius / 1000 }} km de tu ubicación.</p>
                    <p class="text-kartred font-bold mt-2">¡Toca viajar más lejos para quemar rueda!</p>
                </div>
            @endif
        @endif
    </main>

    <script>
        function getLocation() {
            const status = document.getElementById('statusMessage');
            
            if (!navigator.geolocation) {
                status.textContent = ' Tu navegador no soporta geolocalización.';
                return;
            }

            status.textContent = ' Obteniendo tu ubicación satelital... (Acepta el permiso del navegador)';
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lon').value = position.coords.longitude;
                    
                    status.textContent = ' ¡Ubicación encontrada! Consultando la base de datos...';
                    
                    
                    document.getElementById('searchForm').submit();
                },
                (error) => {
                    status.textContent = ' Error al obtener ubicación. Asegúrate de dar permisos en la alerta de tu navegador.';
                    console.error(error);
                }
            );
        }
    </script>
</body>
</html>