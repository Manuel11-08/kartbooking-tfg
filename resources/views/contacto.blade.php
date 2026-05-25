<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Contacto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-kartblack text-white antialiased flex flex-col min-h-screen selection:bg-kartred selection:text-white">

    <nav class="border-b border-kartred/30 bg-black/50 p-4 sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">
                KARTBOOKING
            </a>
            <div class="space-x-6 text-sm font-bold text-gray-300 uppercase tracking-wider">
                <a href="/" class="hover:text-kartred transition">Inicio</a>
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred transition">Buscador</a>
                <a href="{{ route('contacto') }}" class="text-kartred border-b-2 border-kartred pb-1">Contacto</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-10 bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl overflow-hidden">
            
            <div class="bg-black p-12 flex flex-col justify-center border-r border-zinc-800 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-kartred"></div>
                <h2 class="text-4xl font-black uppercase tracking-tight mb-4 text-white">¿Hablamos en <span class="text-kartred">Boxes</span>?</h2>
                <p class="text-gray-400 mb-8 leading-relaxed">
                    Si tienes un circuito y quieres aparecer destacado, o si has encontrado algún error en el trazado de nuestro radar, escríbenos. Nuestro equipo técnico revisa la telemetría a diario.
                </p>
                <div class="space-y-4 font-mono text-sm text-gray-300">
                    <p class="flex items-center gap-3"> Central: Jerez de la Frontera, Cádiz</p>
                    <p class="flex items-center gap-3"> info.kartbooking@kartbooking.com</p>
                </div>
            </div>

            <div class="p-12">
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Nombre del Piloto</label>
                        <input type="text" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred transition outline-none" placeholder="Tu nombre o alias">
                    </div>
                    <div>
                        <label class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Email de Contacto</label>
                        <input type="email" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred transition outline-none" placeholder="ejemplo@email.com">
                    </div>
                    <div>
                        <label class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Mensaje</label>
                        <textarea rows="4" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred transition outline-none" placeholder="¿En qué podemos ayudarte?"></textarea>
                    </div>
                    <button type="button" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20">
                        Enviar Transmisión
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>