<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Usuarios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-black border-r border-kartred/20 p-6">
            <div class="text-2xl font-black text-kartred tracking-tighter mb-10 uppercase italic">Kartbooking Admin</div>
            <nav class="space-y-2">
                <a href="{{ route('admin.users.index') }}" class="block p-3 bg-kartred text-white font-bold rounded shadow-lg">Usuarios</a>
                <a href="{{ route('admin.kartings.index') }}" class="block p-3 text-gray-400 hover:text-white transition italic">Circuitos Locales</a>
                <a href="{{ route('admin.kartings.create') }}" class="block p-3 text-gray-400 hover:text-white transition italic">Añadir Circuito</a>
                <a href="/" class="block p-3 text-gray-400 hover:text-white transition italic mt-10 border-t border-zinc-800 pt-4">Volver a la Web</a>
            </nav>
        </aside>
        <main class="flex-1 p-10">
            <h1 class="text-4xl font-black uppercase mb-8 border-b-4 border-kartred inline-block">Gestión de Usuarios</h1>
            <div class="bg-zinc-900 rounded-lg overflow-hidden border border-zinc-800">
                <table class="w-full text-left">
                    <thead class="bg-black text-kartred uppercase text-sm font-black">
                        <tr><th class="p-4">Piloto</th><th class="p-4">Email</th><th class="p-4 text-right">Acciones</th></tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-zinc-800">
                            <td class="p-4">{{ $user->name }}</td>
                            <td class="p-4 text-gray-500">{{ $user->email }}</td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">@csrf @method('DELETE')
                                    <button class="text-red-600 font-black uppercase text-xs">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>