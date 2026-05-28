<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Tandas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white min-h-screen">
    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <div class="space-x-6 text-sm font-bold uppercase tracking-wider">
                <a href="{{ route('meetups.create') }}" class="bg-kartred text-white px-4 py-2 rounded hover:bg-red-700 transition">Organizar Tanda</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-black uppercase text-white mb-8 border-l-8 border-kartred pl-4">Próximas Tandas</h1>

        @if(session('success'))
            <div class="bg-green-600/20 text-green-400 p-4 rounded mb-6 border border-green-500 font-bold uppercase text-sm tracking-widest">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600/20 text-red-400 p-4 rounded mb-6 border border-red-500 font-bold uppercase text-sm tracking-widest">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($meetups as $meetup)
            <div class="bg-black border border-zinc-800 rounded-xl p-6 relative">
                <div class="mb-4 pb-4 border-b border-zinc-900">
                    <h2 class="text-2xl font-black uppercase text-white">{{ $meetup->title }}</h2>
                    <p class="text-kartred font-bold uppercase text-xs tracking-widest mt-1">{{ $meetup->karting_name }}</p>
                </div>
                
                <div class="space-y-2 mb-6">
                    <p class="text-gray-400 text-sm"><span class="font-bold text-white uppercase">Fecha:</span> {{ $meetup->meet_date->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-400 text-sm"><span class="font-bold text-white uppercase">Organiza:</span> {{ $meetup->creator->name }}</p>
                    <p class="text-gray-400 text-sm"><span class="font-bold text-white uppercase">Parrilla:</span> {{ $meetup->participants->count() }} / {{ $meetup->max_participants }} Pilotos</p>
                </div>

                <div class="flex gap-2">
                    @if($meetup->hasParticipant(auth()->id()))
                        <form action="{{ route('meetups.leave', $meetup) }}" method="POST" class="w-full">
                            @csrf
                            <button class="w-full bg-zinc-800 text-white font-bold py-2 rounded uppercase text-xs tracking-widest hover:bg-zinc-700 border border-zinc-700">Abandonar</button>
                        </form>
                    @else
                        @if($meetup->participants->count() < $meetup->max_participants)
                            <form action="{{ route('meetups.join', $meetup) }}" method="POST" class="w-full">
                                @csrf
                                <button class="w-full bg-kartred text-white font-bold py-2 rounded uppercase text-xs tracking-widest hover:bg-red-700">Unirse</button>
                            </form>
                        @else
                            <button disabled class="w-full bg-zinc-900 text-zinc-600 font-bold py-2 rounded uppercase text-xs tracking-widest cursor-not-allowed border border-zinc-800">Lleno</button>
                        @endif
                    @endif
                    
                    @if(auth()->id() === $meetup->user_id || auth()->user()->is_admin)
                        <form action="{{ route('meetups.destroy', $meetup) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="bg-red-900/50 hover:bg-red-600 text-red-500 hover:text-white px-4 py-2 rounded font-bold uppercase text-xs border border-red-900 transition" onsubmit="return confirm('¿Cancelar tanda?')">X</button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full bg-zinc-900 border border-zinc-800 p-12 rounded-xl text-center">
                <p class="text-gray-500 font-bold uppercase tracking-widest">No hay tandas programadas.</p>
            </div>
            @endforelse
        </div>
    </main>
</body>
</html>