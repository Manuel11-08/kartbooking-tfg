<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Dirección de Carrera</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">
    
    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <div class="flex gap-6 text-sm font-bold text-gray-300 uppercase">
                <a href="/" class="hover:text-kartred">Inicio</a>
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred">Buscador</a>
                <a href="{{ route('meetups.index') }}" class="hover:text-kartred">Tandas</a>
                  @auth
                    <a href="{{ url('/dashboard') }}" class="text-kartred hover:text-white transition">Mi Box</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-kartred transition">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-kartred text-white px-4 py-2 rounded hover:bg-red-700 transition shadow-[0_0_15px_rgba(230,0,0,0.3)]">Licencia</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-16">
        <h1 class="text-4xl font-black uppercase mb-8 border-l-4 border-kartred pl-4">Dirección de Carrera</h1>

        
        @if(session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded mb-6 font-bold uppercase text-sm tracking-widest">
                {{ session('success') }}
            </div>
        @endif

        
        <form action="{{ route('contacto.store') }}" method="POST" class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl shadow-2xl">
            
            @csrf

            <div class="mb-6">
                <label class="block text-kartred font-bold uppercase text-sm mb-2">Nombre del Piloto</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none transition" required>
               
                @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-kartred font-bold uppercase text-sm mb-2">Email de Contacto</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none transition" required>
                @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-kartred font-bold uppercase text-sm mb-2">Transmisión (Mensaje)</label>
                <textarea name="message" rows="5" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:border-kartred outline-none transition" required>{{ old('message') }}</textarea>
                @error('message') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase tracking-widest transition">
                Enviar Transmisión
            </button>
        </form>
    </main>
</body>
</html>