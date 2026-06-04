<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Centro de Mando Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen flex">

    <aside class="w-64 bg-black border-r border-zinc-900 flex flex-col hidden md:flex">
        <div class="p-6 border-b border-zinc-900">
            <h2 class="text-xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</h2>
            <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest">Panel de Control</span>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest rounded transition {{ request()->routeIs('admin.users.*') ? 'text-kartred bg-zinc-900 border-l-2 border-kartred' : 'text-gray-400 hover:text-white hover:bg-zinc-900' }}">Usuarios</a>
            <a href="{{ route('admin.kartings.index') }}" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest rounded transition {{ request()->routeIs('admin.kartings.index') ? 'text-kartred bg-zinc-900 border-l-2 border-kartred' : 'text-gray-400 hover:text-white hover:bg-zinc-900' }}">Circuitos Locales</a>
            <a href="{{ route('admin.kartings.create') }}" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest rounded transition {{ request()->routeIs('admin.kartings.create') ? 'text-kartred bg-zinc-900 border-l-2 border-kartred' : 'text-gray-400 hover:text-white hover:bg-zinc-900' }}">Añadir Circuito</a>
            <a href="{{ route('admin.reviews.index') }}" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest rounded transition {{ request()->routeIs('admin.reviews.*') ? 'text-kartred bg-zinc-900 border-l-2 border-kartred' : 'text-gray-400 hover:text-white hover:bg-zinc-900' }}">Moderación</a>

            <div class="pt-6 mt-6 border-t border-zinc-800">
                <a href="/" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest text-gray-500 hover:text-kartred hover:bg-zinc-900 rounded transition">
                    Volver a la Web
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">

        {{-- Cabecera --}}
        <div class="mb-10">
            <h1 class="text-3xl font-black uppercase tracking-widest text-white">Sistemas en Línea</h1>
            <p class="text-zinc-500 font-mono text-sm mt-1">Centro de Mando — Kartbooking Admin</p>
        </div>

        {{-- Bienvenida --}}
        <div class="bg-black border border-zinc-800 rounded-2xl p-8 shadow-2xl mb-8">
            <p class="text-gray-400 font-mono text-sm leading-relaxed">
                Bienvenido al Centro de Mando<br><br>
                Utiliza el menú de telemetría a tu izquierda para gestionar los pilotos de la parrilla, dar de alta circuitos y moderar la plataforma.
            </p>
        </div>

        {{-- Sección de Telemetría Python --}}
        <div class="bg-black border border-zinc-800 rounded-2xl p-8 shadow-2xl">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-widest text-white">
                        Análisis de Telemetría
                    </h2>
                    <p class="text-zinc-500 font-mono text-xs mt-1">
                        Generado con Python · pandas · matplotlib
                    </p>
                </div>

                {{-- Botón regenerar --}}
                <form method="POST" action="{{ route('admin.telemetria.regenerar') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-zinc-900 hover:bg-kartred border border-zinc-700 hover:border-kartred text-white text-xs font-bold uppercase tracking-widest rounded-lg transition">
                        ↺ Regenerar
                    </button>
                </form>
            </div>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-900/30 border border-green-700 rounded-lg">
                    <p class="text-green-400 text-xs font-mono">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-900/30 border border-red-700 rounded-lg">
                    <p class="text-red-400 text-xs font-mono">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Gráfico --}}
            @if(file_exists(public_path('images/telemetria_chart.png')))
                <img
                    src="{{ asset('images/telemetria_chart.png') }}?v={{ filemtime(public_path('images/telemetria_chart.png')) }}"
                    alt="Gráfico de telemetría de pilotos"
                    class="rounded-xl w-full shadow-lg border border-zinc-800"
                >
            @else
                <div class="flex flex-col items-center justify-center py-16 border border-dashed border-zinc-700 rounded-xl">
                    <p class="text-zinc-500 font-mono text-sm">Sin datos de telemetría disponibles.</p>
                    <p class="text-zinc-600 font-mono text-xs mt-2">Pulsa "Regenerar" para generar el análisis.</p>
                </div>
            @endif

        </div>

    </main>
</body>
</html>