<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Mi Box</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased flex flex-col min-h-screen selection:bg-kartred selection:text-white">

    <nav class="border-b border-kartred/30 bg-black/50 p-4 sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">
                KARTBOOKING
            </a>
            <div class="flex items-center space-x-6 text-sm font-bold text-gray-300 uppercase tracking-wider">
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred transition">Buscador</a>
                
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.users.index') }}" class="text-kartred hover:text-white transition italic">Panel Jefe 🏁</a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-red-500 transition uppercase font-bold cursor-pointer">
                        Apagar Motor (Salir)
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-5xl mx-auto w-full p-6 mt-10">
        
        <div class="bg-black border-l-8 border-kartred p-8 rounded shadow-2xl mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight mb-2">
                    Bienvenido a tu Box, <span class="text-kartred">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-gray-400 font-mono text-sm">Licencia de piloto activa. Correo de contacto: {{ Auth::user()->email }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="bg-kartred/20 text-kartred border border-kartred/50 px-4 py-2 rounded-full font-black uppercase text-xs tracking-widest">
                    ESTADO: EN PISTA
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl hover:border-kartred/50 transition relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-1 h-full bg-kartred transform -translate-x-full group-hover:translate-x-0 transition"></div>
                <h3 class="text-2xl font-black uppercase mb-4 text-white">Radar de Circuitos</h3>
                <p class="text-gray-400 mb-6">Utiliza nuestra conexión por satélite para encontrar las instalaciones de karting más cercanas a tu posición actual.</p>
                <a href="{{ route('kartings.search') }}" class="inline-block bg-zinc-800 hover:bg-kartred text-white font-bold py-2 px-6 rounded uppercase text-sm transition">
                    Abrir Radar
                </a>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl hover:border-zinc-600 transition relative overflow-hidden">
                <h3 class="text-2xl font-black uppercase mb-4 text-gray-500">Telemetría</h3>
                <p class="text-gray-600 mb-6">Pronto podrás registrar tus mejores tiempos en cada circuito y competir en el ranking nacional contra otros pilotos.</p>
                <button disabled class="inline-block bg-zinc-800/30 text-gray-600 cursor-not-allowed font-bold py-2 px-6 rounded uppercase text-sm transition border border-zinc-800">
                    En desarrollo
                </button>
            </div>
            
        </div>
    </main>
</body>
</html>