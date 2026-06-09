<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Recuperar Acceso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased flex flex-col min-h-screen selection:bg-kartred selection:text-white">

    <nav class="border-b border-kartred/30 bg-black p-4 shadow-lg shadow-kartred/5">
        <div class="max-w-7xl mx-auto flex justify-center">
            <a href="/" class="text-3xl font-black text-kartred tracking-widest uppercase italic">
                KARTBOOKING
            </a>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-kartred"></div>

            <h2 class="text-3xl font-black uppercase text-center mb-3 tracking-tight">
                Recuperar <span class="text-kartred">Acceso</span>
            </h2>

            <p class="text-gray-500 text-sm text-center uppercase tracking-widest font-bold mb-8">
                Introduce tu email y te enviamos un enlace para restablecer tu contraseña.
            </p>

            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-black border border-kartred/40 rounded text-kartred text-sm font-bold uppercase tracking-wider text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Email del Piloto</label>
                    <input id="email" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20">
                    Enviar Enlace
                </button>

                <div class="text-center mt-6 border-t border-zinc-800 pt-6">
                    <a href="{{ route('login') }}" class="text-white hover:text-kartred transition font-black uppercase tracking-wider text-xs inline-block">
                        Volver al acceso
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>