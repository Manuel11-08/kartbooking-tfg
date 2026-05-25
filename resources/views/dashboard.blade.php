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
                    <a href="{{ route('admin.users.index') }}" class="text-kartred hover:text-white transition italic">Panel Jefe </a>
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
                    Box de <span class="text-kartred">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-gray-400 font-mono text-sm">Licencia activa. Contacto: {{ Auth::user()->email }}</p>
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
                <p class="text-gray-400 mb-6 text-sm">Utiliza nuestra conexión por satélite para encontrar las instalaciones de karting más cercanas a tu posición actual.</p>
                <a href="{{ route('kartings.search') }}" class="inline-block bg-zinc-800 hover:bg-kartred text-white font-bold py-2 px-6 rounded uppercase text-sm transition">
                    Abrir Radar
                </a>
            </div>

            <div class="bg-black border border-zinc-800 p-8 rounded-xl shadow-xl relative overflow-hidden">
                <h3 class="text-xl font-black uppercase mb-4 text-white border-b border-zinc-800 pb-2">Registrar Nuevo Crono</h3>
                <form action="{{ route('lap-times.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Nombre del Circuito</label>
                        <input type="text" name="karting_name" required placeholder="Ej: Karting Motorland" class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:ring-kartred focus:border-kartred text-sm outline-none transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Mejor Tiempo</label>
                            <input type="text" name="lap_time" required placeholder="01:05.432" class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white font-mono focus:ring-kartred focus:border-kartred text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Fecha</label>
                            <input type="date" name="record_date" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:ring-kartred focus:border-kartred text-sm outline-none transition [color-scheme:dark]">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-3 mt-2 rounded uppercase transition text-sm tracking-wider shadow-lg shadow-kartred/20">
                        Guardar Telemetría
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-10 bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden shadow-2xl">
            <div class="bg-black p-6 border-b border-zinc-800 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase text-white tracking-tight">Mi Historial en Pista</h3>
                <span class="text-gray-500 font-mono text-sm">Vueltas Totales: {{ isset($lapTimes) ? $lapTimes->count() : 0 }}</span>
            </div>

            @if(session('success'))
                <div class="bg-green-600 text-white p-3 text-sm font-bold uppercase tracking-wide text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($lapTimes) && $lapTimes->count() > 0)
                <table class="w-full text-left">
                    <thead class="bg-zinc-950 text-kartred uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="p-4 border-b border-zinc-800">Circuito</th>
                            <th class="p-4 border-b border-zinc-800">Fecha del Récord</th>
                            <th class="p-4 border-b border-zinc-800 text-right">Crono Registrado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        @foreach($lapTimes as $lap)
                        <tr class="hover:bg-zinc-800/50 transition">
                            <td class="p-4 font-bold text-white uppercase">{{ $lap->karting_name }}</td>
                            <td class="p-4 text-gray-400 font-mono text-sm">{{ \Carbon\Carbon::parse($lap->record_date)->format('d / m / Y') }}</td>
                            <td class="p-4 text-right font-mono text-kartred font-black text-xl tracking-tighter">{{ $lap->lap_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-16 text-center text-gray-500">
                    <p class="text-xl mb-2 font-bold uppercase">Aún no hay registros de telemetría</p>
                    <p class="text-sm italic">¡Busca un circuito en el radar, sal a la pista y registra tu primer tiempo!</p>
                </div>
            @endif
        </div>
    </main>
</body>
</html>