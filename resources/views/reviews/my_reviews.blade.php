<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Mis Opiniones</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased min-h-screen">
    
    
    <nav class="border-b border-kartred/30 bg-black/80 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-kartred tracking-widest uppercase italic hover:text-white transition">KARTBOOKING</a>
            <div class="flex gap-4 md:gap-6 text-sm font-bold text-gray-300 uppercase items-center">
                <a href="/" class="hover:text-kartred">Inicio</a>
                <a href="{{ route('kartings.search') }}" class="hover:text-kartred">Buscador</a>
                <a href="{{ url('/dashboard') }}" class="hover:text-kartred">Mi Box</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-white uppercase font-bold text-xs tracking-widest ml-2">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="text-4xl font-black uppercase mb-8 border-l-4 border-kartred pl-4">Gestión de Reseñas</h1>

        @if(session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded mb-6 font-bold uppercase text-sm tracking-widest">
                {{ session('success') }}
            </div>
        @endif

        
        <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl shadow-xl mb-12">
            <h3 class="text-xl font-black uppercase mb-4 text-white">Publicar Nueva Opinión</h3>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <textarea name="content" rows="3" required placeholder="¿Qué te parece la plataforma?..." class="w-full bg-black border border-zinc-700 rounded p-4 text-white focus:border-kartred outline-none transition mb-4 resize-none"></textarea>
                <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-black py-3 px-8 rounded uppercase tracking-widest transition text-sm shadow-[0_0_15px_rgba(230,0,0,0.3)]">
                    Publicar en Portada
                </button>
            </form>
        </div>

        
        <h3 class="text-2xl font-black uppercase mb-6 text-white border-l-4 border-zinc-700 pl-4">Tus Publicaciones</h3>
        
        <div class="space-y-6">
            @forelse($reviews as $review)
                <div class="bg-black border border-zinc-800 p-6 rounded-xl shadow-lg relative">
                    
                    <!-- Vista normal de la reseña -->
                    <div id="view-review-{{ $review->id }}">
                        <p class="text-gray-300 italic mb-4">"{{ $review->content }}"</p>
                        <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mb-4">Publicado: {{ $review->created_at->format('d/m/Y H:i') }}</p>
                        
                        <div class="flex gap-2">
                            <button onclick="toggleEdit({{ $review->id }})" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition border border-zinc-700">
                                Editar
                            </button>
                            <form action="{{ route('reviews.userDestroy', $review) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar tu reseña?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-900/50 hover:bg-red-800 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition border border-red-900">
                                    Borrar
                                </button>
                            </form>
                        </div>
                    </div>

                    
                    <div id="edit-review-{{ $review->id }}" class="hidden">
                        <form action="{{ route('reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="content" rows="3" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-4 text-white focus:border-kartred outline-none transition mb-4 resize-none">{{ $review->content }}</textarea>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-kartred hover:bg-red-700 text-white font-bold py-2 px-6 rounded text-xs uppercase tracking-widest transition">
                                    Guardar Cambios
                                </button>
                                <button type="button" onclick="toggleEdit({{ $review->id }})" class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition border border-zinc-700">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            @empty
                <div class="bg-zinc-900/50 border border-zinc-800 p-10 rounded-xl text-center">
                    <p class="text-gray-500 uppercase tracking-widest text-sm font-bold">No has publicado ninguna reseña aún.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        function toggleEdit(id) {
            const viewDiv = document.getElementById('view-review-' + id);
            const editDiv = document.getElementById('edit-review-' + id);
            
            if (viewDiv.classList.contains('hidden')) {
                viewDiv.classList.remove('hidden');
                editDiv.classList.add('hidden');
            } else {
                viewDiv.classList.add('hidden');
                editDiv.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>