<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Añadir Circuito</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased">
    <div class="flex min-h-screen">
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

        <main class="flex-1 p-10">
            <h1 class="text-3xl font-black uppercase mb-6 border-l-8 border-kartred pl-4">Nuevo Circuito Local</h1>
            
            <form action="{{ route('admin.kartings.store') }}" method="POST" class="max-w-3xl bg-zinc-900 p-8 rounded-lg border border-zinc-800 shadow-xl">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block uppercase text-xs font-bold text-gray-500 mb-2">Nombre de la Pista</label>
                        <input type="text" name="name" placeholder="Ej: Karting Motorland" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block uppercase text-xs font-bold text-gray-500 mb-2">Latitud GPS</label>
                            <input type="text" name="latitude" placeholder="Ej: 41.0487" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" required>
                        </div>
                        <div>
                            <label class="block uppercase text-xs font-bold text-gray-500 mb-2">Longitud GPS</label>
                            <input type="text" name="longitude" placeholder="Ej: -0.1345" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20 mt-4">
                        Añadir a Base de Datos
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>