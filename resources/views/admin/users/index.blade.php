<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Gestión de Pilotos</title>
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

   
    <main class="flex-1 p-10">
        <h1 class="text-4xl font-black uppercase tracking-widest border-b-4 border-kartred inline-block mb-8">Gestión de Pilotos</h1>

        @if(session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded mb-6 font-bold uppercase text-sm tracking-widest w-fit">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-black border border-zinc-800 rounded-xl overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-900 border-b border-zinc-800 text-kartred text-xs uppercase tracking-widest">
                        <th class="p-4">ID</th>
                        <th class="p-4">Piloto</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Rango</th>
                        <th class="p-4 text-right">Acciones de Box</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                    <tr class="border-b border-zinc-800 hover:bg-zinc-900/50 transition">
                        <td class="p-4 text-gray-500 font-mono">#{{ $user->id }}</td>
                        <td class="p-4 font-bold text-white">{{ $user->name }}</td>
                        <td class="p-4 text-gray-400">{{ $user->email }}</td>
                        <td class="p-4">
                            @if($user->is_admin)
                                <span class="bg-kartred/20 text-kartred border border-kartred/50 px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest">Jefe de Equipo</span>
                            @else
                                <span class="bg-zinc-800 text-gray-400 border border-zinc-700 px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest">Piloto Normal</span>
                            @endif
                        </td>
                        
                        <td class="p-4 flex justify-end gap-2">
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-2 {{ $user->is_admin ? 'bg-zinc-800 hover:bg-zinc-700 text-gray-300' : 'bg-kartred hover:bg-red-700 text-white' }} text-[10px] font-black rounded uppercase transition border border-zinc-700 min-w-[110px]">
                                    {{ $user->is_admin ? 'Quitar Admin' : 'Hacer Admin' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres expulsar a este piloto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-zinc-800 hover:bg-red-600 text-white text-[10px] font-black rounded uppercase transition border border-zinc-700">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 font-bold uppercase tracking-widest text-sm">
                            No hay más pilotos registrados en la parrilla actualmente.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>