<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - El portal de los pilotos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased flex flex-col min-h-screen selection:bg-kartred selection:text-white">

    <nav class="border-b border-kartred/30 bg-black/50 p-4 sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">
                KARTBOOKING
            </a>
            <div class="space-x-6 text-sm font-bold text-gray-300 uppercase tracking-wider hidden md:block">
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred transition">Buscador</a>
                <a href="{{ route('contacto') }}" class="hover:text-kartred transition">Contacto</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-kartred hover:text-white transition">Mi Box</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-kartred transition">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-kartred text-white px-4 py-2 rounded hover:bg-red-700 transition shadow-[0_0_15px_rgba(230,0,0,0.3)]">Licencia</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-kartred/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <span class="bg-zinc-800 text-kartred text-xs font-black uppercase tracking-widest px-4 py-1 rounded-full mb-6 inline-block border border-kartred/30">
                La plataforma definitiva
            </span>
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-6">
                Quema <span class="text-kartred italic">Rueda.</span><br>No tu tiempo.
            </h1>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                Encuentra los mejores circuitos de karting cerca de tu posición. Consulta trazados, coordenadas y prepárate para batir el crono.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('kartings.search') }}" class="w-full sm:w-auto bg-kartred hover:bg-red-700 text-white font-black py-4 px-8 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20 text-lg">
                    Escanear Zona Ahora
                </a>
                @guest
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-transparent border-2 border-zinc-700 hover:border-kartred text-white font-black py-4 px-8 rounded uppercase transition tracking-wider text-lg">
                    Crear Cuenta
                </a>
                @endguest
            </div>
        </div>
    </main>

    <footer class="border-t border-zinc-900 bg-black py-8 text-center text-sm font-bold text-gray-600 uppercase tracking-widest">
        <p>&copy; {{ date('Y') }} Kartbooking. Proyecto TFG. Todos los derechos reservados.</p>
    </footer>
</body>
</html>