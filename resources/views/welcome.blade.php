<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - El portal de los pilotos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        
        .bg-grid-pattern {
            background-image: linear-gradient(to right, rgba(255,255,255,0.02) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-zinc-950 text-white antialiased flex flex-col min-h-screen selection:bg-kartred selection:text-white bg-grid-pattern">

    <!-- NAVEGACIÓN -->
    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic hover:text-white transition">
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

    
    <header class="relative flex items-center justify-center py-40 overflow-hidden border-b border-zinc-900 bg-black/40">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-kartred/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <span class="bg-black text-kartred text-xs font-black uppercase tracking-widest px-4 py-1 rounded-full mb-6 inline-block border border-kartred/30 shadow-[0_0_10px_rgba(230,0,0,0.2)]">
                La red número 1 de pilotos
            </span>
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-6 drop-shadow-2xl">
                Quema <span class="text-kartred italic">Rueda.</span><br>No tu tiempo.
            </h1>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto font-medium">
                Localiza los mejores circuitos en tu zona, estudia los trazados y guarda tus mejores tiempos en la telemetría.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('kartings.search') }}" class="w-full sm:w-auto bg-kartred hover:bg-red-700 text-white font-black py-4 px-8 rounded uppercase transition tracking-wider shadow-[0_0_20px_rgba(230,0,0,0.4)] text-lg hover:scale-105 duration-300">
                    Escanear Zona Ahora
                </a>
                @guest
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-black border-2 border-zinc-700 hover:border-kartred text-white font-black py-4 px-8 rounded uppercase transition tracking-wider text-lg hover:bg-zinc-900">
                    Crear Cuenta
                </a>
                @endguest
            </div>
        </div>
    </header>

    <!-- ESTADÍSTICAS -->
    <section class="bg-zinc-900 border-b border-zinc-800 py-12 shadow-2xl relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-zinc-700">
            <div class="py-2 hover:scale-105 transition duration-300">
                <p class="text-5xl font-black text-white tracking-tighter mb-2">+500</p>
                <p class="text-kartred font-bold uppercase tracking-widest text-xs">Pilotos en Parrilla</p>
            </div>
            <div class="py-2 hover:scale-105 transition duration-300">
                <p class="text-5xl font-black text-white tracking-tighter mb-2">120</p>
                <p class="text-kartred font-bold uppercase tracking-widest text-xs">Circuitos Mapeados</p>
            </div>
            <div class="py-2 hover:scale-105 transition duration-300">
                <p class="text-5xl font-black text-white tracking-tighter mb-2">+3K</p>
                <p class="text-kartred font-bold uppercase tracking-widest text-xs">Vueltas Registradas</p>
            </div>
        </div>
    </section>

    <!-- CARACTERÍSTICAS -->
    <section class="py-24 bg-black/60 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black uppercase tracking-tight mb-4 text-white">Todo lo que necesitas en tu <span class="text-kartred">Box</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Kartbooking no es solo un buscador, es la herramienta definitiva para llevar tu afición al siguiente nivel.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-zinc-900 p-8 rounded-xl border border-zinc-800 hover:border-kartred hover:-translate-y-2 transition duration-300 shadow-xl">
                    <div class="text-kartred text-2xl font-black mb-4">GPS</div>
                    <h3 class="text-2xl font-black uppercase mb-3 text-white">Radar Extremo</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Conectamos con satélites para encontrar pistas de asfalto y tierra en tu radio de acción exacto. No vuelvas a perderte un buen trazado.</p>
                </div>
                <div class="bg-zinc-900 p-8 rounded-xl border border-zinc-800 hover:border-kartred hover:-translate-y-2 transition duration-300 shadow-xl">
                    <div class="text-kartred text-2xl font-black mb-4">CRONO</div>
                    <h3 class="text-2xl font-black uppercase mb-3 text-white">Telemetría Nube</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Guarda tus cronos. Analiza tu evolución en cada pista a lo largo del tiempo con nuestro panel exclusivo para pilotos registrados.</p>
                </div>
                <div class="bg-zinc-900 p-8 rounded-xl border border-zinc-800 hover:border-kartred hover:-translate-y-2 transition duration-300 shadow-xl">
                    <div class="text-kartred text-2xl font-black mb-4">LIGA</div>
                    <h3 class="text-2xl font-black uppercase mb-3 text-white">Comunidad Motor</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Forma parte de una base de datos global. Próximamente habilitaremos ligas locales y tablas de clasificación para ver quién manda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CIRCUITOS DESTACADOS -->
    <section class="py-24 bg-zinc-950 border-y border-zinc-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-black uppercase tracking-tight mb-2 text-white border-l-8 border-kartred pl-4">Circuitos Destacados</h2>
                    <p class="text-gray-500 pl-4">Trazados exigentes con enlace directo a sus coordenadas.</p>
                </div>
                <a href="{{ route('kartings.search') }}" class="text-kartred hover:text-white uppercase font-bold text-sm tracking-widest transition mt-6 md:mt-0 border-b border-kartred pb-1">Ver catálogo completo</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group bg-black rounded-xl overflow-hidden border border-zinc-800 hover:border-kartred transition duration-300 shadow-2xl block">
                    <div class="h-56 overflow-hidden relative flex items-center justify-center bg-zinc-900 border-b border-zinc-800">
                        <svg class="w-20 h-20 text-zinc-800 group-hover:text-kartred transition duration-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L6.113 22.38a.75.75 0 0 1-1.06 0l-1.434-1.434a.75.75 0 0 1 0-1.06l2.008-2.008a3 3 0 0 1 2.122-.879H9Zm0 0a3 3 0 0 1 3-3h1.5a3 3 0 0 1 3 3m-7.5 0v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V17.25m0 0v1.5c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V15.75M12 3v1.5M12 18.75V21m-4.72-15.53 1.06 1.06m7.32-1.06-1.06 1.06M3 12h1.5m15 0H21M4.22 19.78l1.06-1.06m13.44 1.06-1.06-1.06X" />
                        </svg>
                        <div class="absolute top-4 left-4 bg-black/80 text-xs font-bold px-3 py-1 rounded border border-zinc-700 tracking-wider">CIRCUITO 01</div>
                    </div>
                    <div class="p-6 relative z-20">
                        <span class="text-xs font-black text-kartred uppercase tracking-widest mb-1 block">Madrid</span>
                        <h3 class="text-xl font-black uppercase text-white mb-2 group-hover:text-kartred transition">Karting Carlos Sainz</h3>
                        <p class="text-gray-400 text-sm font-mono mb-4">Indoor - Asfalto Técnico</p>
                    </div>
                </div>
                
                <div class="group bg-black rounded-xl overflow-hidden border border-zinc-800 hover:border-kartred transition duration-300 shadow-2xl block">
                    <div class="h-56 overflow-hidden relative flex items-center justify-center bg-zinc-900 border-b border-zinc-800">
                        <svg class="w-20 h-20 text-zinc-800 group-hover:text-kartred transition duration-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L6.113 22.38a.75.75 0 0 1-1.06 0l-1.434-1.434a.75.75 0 0 1 0-1.06l2.008-2.008a3 3 0 0 1 2.122-.879H9Zm0 0a3 3 0 0 1 3-3h1.5a3 3 0 0 1 3 3m-7.5 0v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V17.25m0 0v1.5c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V15.75M12 3v1.5M12 18.75V21m-4.72-15.53 1.06 1.06m7.32-1.06-1.06 1.06M3 12h1.5m15 0H21M4.22 19.78l1.06-1.06m13.44 1.06-1.06-1.06X" />
                        </svg>
                        <div class="absolute top-4 left-4 bg-black/80 text-xs font-bold px-3 py-1 rounded border border-zinc-700 tracking-wider">CIRCUITO 02</div>
                    </div>
                    <div class="p-6 relative z-20">
                        <span class="text-xs font-black text-kartred uppercase tracking-widest mb-1 block">Málaga</span>
                        <h3 class="text-xl font-black uppercase text-white mb-2 group-hover:text-kartred transition">KartCenter Campillos</h3>
                        <p class="text-gray-400 text-sm font-mono mb-4">Outdoor - Trazado CIK-FIA</p>
                    </div>
                </div>

                <div class="group bg-black rounded-xl overflow-hidden border border-zinc-800 hover:border-kartred transition duration-300 shadow-2xl block">
                    <div class="h-56 overflow-hidden relative flex items-center justify-center bg-zinc-900 border-b border-zinc-800">
                        <svg class="w-20 h-20 text-zinc-800 group-hover:text-kartred transition duration-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L6.113 22.38a.75.75 0 0 1-1.06 0l-1.434-1.434a.75.75 0 0 1 0-1.06l2.008-2.008a3 3 0 0 1 2.122-.879H9Zm0 0a3 3 0 0 1 3-3h1.5a3 3 0 0 1 3 3m-7.5 0v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V17.25m0 0v1.5c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V15.75M12 3v1.5M12 18.75V21m-4.72-15.53 1.06 1.06m7.32-1.06-1.06 1.06M3 12h1.5m15 0H21M4.22 19.78l1.06-1.06m13.44 1.06-1.06-1.06X" />
                        </svg>
                        <div class="absolute top-4 left-4 bg-black/80 text-xs font-bold px-3 py-1 rounded border border-zinc-700 tracking-wider">CIRCUITO 03</div>
                    </div>
                    <div class="p-6 relative z-20">
                        <span class="text-xs font-black text-kartred uppercase tracking-widest mb-1 block">Teruel</span>
                        <h3 class="text-xl font-black uppercase text-white mb-2 group-hover:text-kartred transition">Karting Motorland</h3>
                        <p class="text-gray-400 text-sm font-mono mb-4">Outdoor - Alta Velocidad</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    <section class="py-20 bg-black border-b border-zinc-900">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-12 text-center text-white">Opiniones en <span class="text-kartred">Boxes</span></h2>

            
            <div class="text-center mb-16">
                @auth
                    <a href="{{ route('mis-resenas') }}" class="inline-block bg-zinc-900 border border-zinc-700 hover:border-kartred text-white font-bold py-3 px-8 rounded uppercase transition duration-300 tracking-wider text-sm shadow-lg">
                        Escribir / Gestionar Mis Reseñas
                    </a>
                @else
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm bg-zinc-900/50 max-w-2xl mx-auto p-6 rounded-xl border border-zinc-800">
                        <a href="{{ route('login') }}" class="text-kartred hover:text-white transition border-b border-kartred pb-1">Inicia sesión</a> 
                        para dejar tu opinión en boxes.
                    </p>
                @endauth
            </div>

            <!-- Lista de reseñas de la Base de Datos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($reviews as $review)
                    <div class="bg-zinc-900 p-8 rounded-lg border border-zinc-800 relative hover:border-kartred transition duration-300">
                        <svg class="w-8 h-8 text-zinc-800 absolute top-4 right-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        <p class="text-gray-300 italic mb-6 relative z-10">"{{ $review->content }}"</p>
                        <p class="text-kartred font-black uppercase text-sm">{{ $review->user->name }}</p>
                        <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="col-span-full bg-zinc-900/50 p-10 rounded-xl border border-zinc-800 text-center">
                        <p class="text-gray-500 font-bold uppercase tracking-widest">Todavía no hay telemetrías registradas.</p>
                        <p class="text-zinc-600 text-xs mt-2">¡Sé el primer piloto en opinar!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

   
    <section class="py-24 bg-black/80 backdrop-blur-sm">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-black uppercase tracking-tight mb-8 text-white">Nacidos en la <span class="text-kartred">Pista</span></h2>
            <div class="space-y-6 text-gray-400 leading-relaxed text-lg">
                <p>
                    Kartbooking nace de la frustración real de los pilotos aficionados. Organizar una tanda de karting con amigos siempre implicaba perder horas buscando circuitos en mapas, comprobando si seguían abiertos o llamando por teléfono.
                </p>
                <p>
                    Nuestro objetivo es centralizar la información. Conectamos bases de datos para ofrecerte un radar preciso, y te damos las herramientas para que tú solo tengas que preocuparte de bajar el crono.
                </p>
            </div>
            <div class="mt-12">
                <a href="{{ route('contacto') }}" class="inline-block bg-zinc-900 border border-zinc-700 hover:border-kartred text-white font-bold py-4 px-8 rounded uppercase transition duration-300 tracking-wider text-sm shadow-lg hover:shadow-kartred/20">
                    Contactar con Dirección de Carrera
                </a>
            </div>
        </div>
    </section>

 
    <footer class="border-t border-zinc-900 bg-black py-12 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-2xl font-black text-zinc-800 tracking-widest uppercase italic mb-6">KARTBOOKING</h3>
            <p class="text-sm font-bold text-zinc-600 uppercase tracking-widest">© {{ date('Y') }} Kartbooking. Proyecto TFG. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>