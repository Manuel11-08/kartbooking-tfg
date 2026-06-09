<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Mi Box</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">

    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic">KARTBOOKING</a>
            <div class="flex gap-4 md:gap-6 text-sm font-bold text-gray-300 uppercase items-center">
                <a href="/" class="hover:text-kartred hidden md:block">Inicio</a>
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred hidden md:block">Buscador</a>
                <a href="{{ route('contacto') }}" class="hover:text-kartred transition">Contacto</a>
                <a href="{{ route('meetups.index') }}" class="hover:text-kartred">Tandas</a>
                
                @if(auth()->user()->is_admin == 1 || auth()->user()->role === 'admin' || auth()->user()->type === 'admin') 
                    <a href="{{ route('admin.dashboard') }}" class="text-kartred border border-kartred px-3 py-1.5 rounded hover:bg-kartred hover:text-white transition tracking-widest font-black shadow-[0_0_10px_rgba(230,0,0,0.3)] bg-kartred/10">
                        Panel Admin
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-white uppercase font-bold text-xs tracking-widest ml-2">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="md:col-span-1">
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded mb-6 font-bold uppercase text-sm tracking-widest">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-black border border-zinc-800 p-8 rounded-xl shadow-xl relative overflow-hidden">
                <h3 class="text-xl font-black uppercase mb-4 text-white border-b border-zinc-800 pb-2">Registrar Nuevo Crono</h3>
                <form action="{{ route('lap-times.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Nombre del Circuito</label>
                        <input type="text" name="karting_name" required placeholder="Ej: Karting Motorland" class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:border-kartred text-sm outline-none transition">
                    </div>
                    <div>
                        <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Mejor Tiempo</label>
                        <input type="text" name="lap_time" required placeholder="01:05.432" class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white font-mono focus:border-kartred text-sm outline-none transition">
                    </div>
                    <div>
                        <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Fecha de la Vuelta</label>
                        <input type="date" name="record_date" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:border-kartred text-sm outline-none transition">
                    </div>
                    <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-3 rounded uppercase tracking-widest transition text-sm mt-2">
                        Guardar Crono
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <h3 class="text-2xl font-black uppercase mb-6 text-white border-l-4 border-kartred pl-4">Tu Historial de Pista</h3>

            @if(isset($lapTimes) && $lapTimes->count() > 0)
                <div class="space-y-4">
                    @foreach($lapTimes as $lapTime)
                        <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-xl shadow-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            
                            <div class="flex-1">
                                <h4 class="text-lg font-black text-white uppercase">{{ $lapTime->karting_name }}</h4>
                                <p class="text-kartred font-mono text-xl font-bold">{{ $lapTime->lap_time }}</p>
                                <p class="text-xs text-zinc-500 uppercase tracking-widest mt-1">Vuelta realizada el: {{ \Carbon\Carbon::parse($lapTime->record_date)->format('d/m/Y') }}</p>
                            </div>

                            <div class="flex gap-2 w-full sm:w-auto">
                                <button onclick="toggleEdit('edit-form-{{ $lapTime->id }}')" class="flex-1 sm:flex-none bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition border border-zinc-700">
                                    Editar
                                </button>
                                
                                <form action="{{ route('lap-times.destroy', $lapTime) }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Seguro que quieres borrar este crono?')" class="w-full bg-red-900/50 hover:bg-red-800 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition border border-red-900">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div id="edit-form-{{ $lapTime->id }}" class="hidden bg-black border border-zinc-800 p-5 rounded-xl mt-2 mb-6 shadow-inner">
                            <form action="{{ route('lap-times.update', $lapTime) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
                                @csrf
                                @method('PUT')
                                <div class="flex-1 w-full">
                                    <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Circuito</label>
                                    <input type="text" name="karting_name" value="{{ $lapTime->karting_name }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:border-kartred text-sm outline-none transition">
                                </div>
                                <div class="flex-1 w-full">
                                    <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Tiempo</label>
                                    <input type="text" name="lap_time" value="{{ $lapTime->lap_time }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white font-mono focus:border-kartred text-sm outline-none transition">
                                </div>
                                <div class="flex-1 w-full">
                                    <label class="block uppercase text-[10px] font-black text-gray-500 mb-1 tracking-widest">Fecha</label>
                                    <input type="date" name="record_date" value="{{ explode(' ', $lapTime->record_date)[0] }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-2 text-white focus:border-kartred text-sm outline-none transition">
                                </div>
                                <div class="flex gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                                    <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-bold py-2 px-6 rounded text-xs uppercase tracking-widest transition h-[38px]">
                                        Actualizar
                                    </button>
                                    <button type="button" onclick="toggleEdit('edit-form-{{ $lapTime->id }}')" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition h-[38px]">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-zinc-900/50 border border-zinc-800 p-10 rounded-xl text-center">
                    <p class="text-gray-500 uppercase tracking-widest text-sm font-bold">Tu telemetría está vacía.</p>
                    <p class="text-zinc-600 text-xs mt-2">Registra tu primer crono en el panel izquierdo.</p>
                </div>
            @endif
        </div>

    </main>

    <script>
        function toggleEdit(id) {
            const form = document.getElementById(id);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</body>
</html>