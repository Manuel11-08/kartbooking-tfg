<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Dirección de Carrera</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">
    
   {{-- Barra de navegación con menú responsive usando Alpine.js --}}
<nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50 backdrop-blur-md" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto flex justify-between items-center w-full">

        {{-- Logo --}}
        <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic hover:text-white transition">
            KARTBOOKING
        </a>

        {{-- Menú de escritorio --}}
        <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-300 uppercase tracking-wider">
            <a href="/" class="hover:text-kartred transition">Inicio</a>
            <a href="{{ route('contacto') }}" class="hover:text-kartred transition">Contacto</a>
            <a href="{{ route('meetups.index') }}" class="hover:text-kartred transition">Tandas</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-kartred hover:text-white transition">Mi Box</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-kartred transition">Entrar</a>
                <a href="{{ route('register') }}" class="bg-kartred text-white px-4 py-2 rounded hover:bg-red-700 transition">Licencia</a>
            @endauth
        </div>

        {{-- Botón hamburguesa en móvil --}}
        <button @click="open = !open" class="md:hidden text-white p-2" aria-label="Abrir menú">
            <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Menú desplegable móvil --}}
    <div x-show="open" x-cloak class="md:hidden mt-4 px-2 space-y-3 text-sm font-bold text-gray-300 uppercase tracking-wider" style="display: none;">
        <a href="/" class="block hover:text-kartred transition" @click="open = false">Inicio</a>
            <a href="{{ route('kartings.search') }}" class="block hover:text-kartred transition" @click="open = false">Buscador</a>
        <a href="{{ route('meetups.index') }}" class="block hover:text-kartred transition" @click="open = false">Tandas</a>
        @auth
            <a href="{{ url('/dashboard') }}" class="block text-kartred hover:text-white transition" @click="open = false">Mi Box</a>
        @else
            <a href="{{ route('login') }}" class="block hover:text-kartred transition" @click="open = false">Entrar</a>
            <a href="{{ route('register') }}" class="block bg-kartred text-white px-4 py-2 rounded text-center hover:bg-red-700 transition" @click="open = false">Licencia</a>
        @endauth
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