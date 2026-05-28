<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Organizar Tanda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white min-h-screen">
    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <a href="{{ route('meetups.index') }}" class="text-sm font-bold text-gray-300 hover:text-white uppercase tracking-wider"><- Volver</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-6 py-12">
        <div class="bg-black border border-zinc-800 p-8 rounded-xl shadow-2xl">
            <h1 class="text-3xl font-black uppercase text-white mb-6 border-b border-zinc-900 pb-4">Organizar Tanda</h1>

            <form action="{{ route('meetups.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-kartred font-bold uppercase tracking-widest text-xs mb-2">Nombre del Evento</label>
                    <input type="text" name="title" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none" placeholder="Ej: Pique de Sábado">
                </div>

                <div>
                    <label class="block text-kartred font-bold uppercase tracking-widest text-xs mb-2">Circuito</label>
                    <input type="text" name="karting_name" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none" placeholder="Nombre del karting">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-kartred font-bold uppercase tracking-widest text-xs mb-2">Fecha y Hora</label>
                        <input type="datetime-local" name="meet_date" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none" style="color-scheme: dark;">
                    </div>
                    <div>
                        <label class="block text-kartred font-bold uppercase tracking-widest text-xs mb-2">Plazas Máximas</label>
                        <input type="number" name="max_participants" min="2" max="50" value="10" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-kartred font-bold uppercase tracking-widest text-xs mb-2">Detalles / Normas</label>
                    <textarea name="description" rows="3" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none" placeholder="Información extra..."></textarea>
                </div>

                <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase tracking-widest transition">Publicar Evento</button>
            </form>
        </div>
    </main>
</body>
</html>