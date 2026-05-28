<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Editar Circuito</title>
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
            
            <div class="pt-6 mt-6 border-t border-zinc-800">
                <a href="/" class="block px-4 py-3 text-sm font-bold uppercase tracking-widest text-gray-500 hover:text-kartred hover:bg-zinc-900 rounded transition">
                     Volver a la Web
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <h1 class="text-4xl font-black uppercase tracking-widest border-b-4 border-kartred inline-block mb-8">Editar Pista</h1>

        <form action="{{ route('admin.kartings.update', $karting) }}" method="POST" class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl shadow-2xl max-w-2xl">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-kartred font-bold uppercase text-sm mb-2">Nombre del Karting</label>
                <input type="text" name="name" value="{{ $karting->name }}" required class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none">
            </div>
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-kartred font-bold uppercase text-sm mb-2">Latitud</label>
                    <input type="text" name="latitude" value="{{ $karting->latitude }}" required class="w-full bg-black border border-zinc-700 rounded p-3 text-white font-mono focus:border-kartred outline-none">
                </div>
                <div>
                    <label class="block text-kartred font-bold uppercase text-sm mb-2">Longitud</label>
                    <input type="text" name="longitude" value="{{ $karting->longitude }}" required class="w-full bg-black border border-zinc-700 rounded p-3 text-white font-mono focus:border-kartred outline-none">
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-black py-4 px-8 rounded uppercase tracking-widest transition">Actualizar Coordenadas</button>
                <a href="{{ route('admin.kartings.index') }}" class="bg-zinc-800 hover:bg-zinc-700 text-white font-black py-4 px-8 rounded uppercase tracking-widest transition">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>