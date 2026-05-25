<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - {{ $name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased flex flex-col min-h-screen">
    
    <header class="bg-black border-b-2 border-kartred p-4 shadow-lg shadow-kartred/10">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="/" class="text-3xl font-black text-white italic tracking-tighter uppercase">
                Kart<span class="text-kartred">booking</span>
            </a>
            <a href="/buscar-kartings" class="text-gray-400 hover:text-white transition font-bold uppercase text-sm">
                Volver al buscador
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="max-w-3xl w-full bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl overflow-hidden relative">
            
            <div class="h-4 w-full bg-kartred"></div>

            <div class="p-10 text-center">
                <span class="bg-zinc-800 text-gray-400 text-xs font-black uppercase tracking-widest px-4 py-1 rounded-full mb-4 inline-block">
                    Ficha Oficial
                </span>
                <h1 class="text-5xl font-black uppercase tracking-tight mb-2">{{ $name }}</h1>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-left border-t border-zinc-800 pt-8">
                    <div class="bg-black p-6 rounded border border-zinc-800">
                        <h3 class="text-kartred font-black uppercase text-sm mb-1">Coordenadas GPS</h3>
                        <p class="font-mono text-gray-300">Lat: {{ $lat }}</p>
                        <p class="font-mono text-gray-300">Lon: {{ $lon }}</p>
                    </div>
                    <div class="bg-black p-6 rounded border border-zinc-800 flex flex-col justify-center items-center">
                        <h3 class="text-gray-500 font-bold uppercase text-xs mb-3">Trazado verificado por Kartbooking</h3>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lon }}" target="_blank" 
                           class="w-full text-center bg-kartred hover:bg-red-700 text-white font-black py-3 rounded uppercase transition shadow-lg shadow-kartred/20">
                             Cómo Llegar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>