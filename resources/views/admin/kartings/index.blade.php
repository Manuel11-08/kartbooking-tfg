<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Circuitos Locales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-black border-r border-kartred/20 p-6">
            <div class="text-2xl font-black text-kartred tracking-tighter mb-10 uppercase italic">
                Kartbooking Admin
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.users.index') }}" class="block p-3 text-gray-400 hover:text-white transition italic">Usuarios</a>
                <a href="{{ route('admin.kartings.index') }}" class="block p-3 bg-kartred text-white font-bold rounded shadow-lg shadow-kartred/20">Circuitos Locales</a>
                <a href="{{ route('admin.kartings.create') }}" class="block p-3 text-gray-400 hover:text-white transition italic">Añadir Circuito</a>
                <a href="/" class="block p-3 text-gray-400 hover:text-white transition italic mt-10 border-t border-zinc-800 pt-4">Volver a la Web</a>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-black uppercase tracking-widest border-b-4 border-kartred inline-block">
                    Tus Circuitos Locales
                </h1>
                <a href="{{ route('admin.kartings.create') }}" class="bg-kartred hover:bg-red-700 text-white font-bold py-2 px-6 rounded uppercase transition shadow-lg shadow-kartred/20">
                    + Nuevo Circuito
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded mb-6 font-bold uppercase text-sm tracking-wide">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-zinc-900 rounded-lg overflow-hidden border border-zinc-800 shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-black text-kartred uppercase text-sm font-black italic">
                        <tr>
                            <th class="p-4 border-b border-zinc-800">ID</th>
                            <th class="p-4 border-b border-zinc-800">Nombre del Karting</th>
                            <th class="p-4 border-b border-zinc-800">Latitud</th>
                            <th class="p-4 border-b border-zinc-800">Longitud</th>
                            <th class="p-4 border-b border-zinc-800 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        @foreach($kartings as $karting)
                        <tr class="hover:bg-zinc-800/50 transition">
                            <td class="p-4 font-mono text-gray-500">#{{ $karting->id }}</td>
                            <td class="p-4 font-bold uppercase tracking-tight">{{ $karting->name }}</td>
                            <td class="p-4 text-gray-400 font-mono">{{ $karting->latitude }}</td>
                            <td class="p-4 text-gray-400 font-mono">{{ $karting->longitude }}</td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.kartings.destroy', $karting) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres demoler este circuito?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-zinc-800 hover:bg-red-600 text-white text-[10px] font-black rounded uppercase transition">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($kartings->isEmpty())
                <div class="mt-10 p-10 bg-zinc-900 rounded border border-dashed border-zinc-700 text-center">
                    <p class="text-gray-500 italic">Aún no has añadido ningún circuito propio a la base de datos.</p>
                </div>
            @endif
        </main>
    </div>
</body>
</html>