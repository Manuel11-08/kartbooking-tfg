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

    
    <main class="flex-1 p-10 flex flex-col justify-center items-center">
        <div class="bg-black border border-zinc-800 rounded-2xl p-12 shadow-2xl text-center max-w-2xl w-full">
            
            <h1 class="text-3xl font-black uppercase tracking-widest text-white mb-4">Sistemas en Línea</h1>
            <p class="text-gray-400 font-mono text-sm leading-relaxed">
                Bienvenido al Centro de Mando<br><br>
                Utiliza el menú de telemetría a tu izquierda para gestionar los pilotos de la parrilla, dar de alta circuitos y moderar la plataforma.
            </p>
        </div>
    </main>
</body>
</html>