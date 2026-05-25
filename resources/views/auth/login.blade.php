<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Iniciar Sesión</title>
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
            
            <h2 class="text-3xl font-black uppercase text-center mb-8 tracking-tight">
                Acceso a <span class="text-kartred">Boxes</span>
            </h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Email del Piloto</label>
                    <input id="email" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <div>
                    <label for="password" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Contraseña</label>
                    <input id="password" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-zinc-700 bg-black text-kartred shadow-sm focus:ring-kartred" name="remember">
                        <span class="ml-2 text-sm text-gray-400 font-bold uppercase tracking-wider">Recordar piloto</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-kartred hover:text-white transition font-bold uppercase tracking-wider" href="{{ route('password.request') }}">
                            ¿Olvidaste la clave?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20">
                    Encender Motores
                </button>
                
                <div class="text-center mt-6 border-t border-zinc-800 pt-6">
                    <p class="text-sm text-gray-500 uppercase tracking-widest text-xs font-bold mb-2">¿Aún no tienes licencia?</p>
                    <a href="{{ route('register') }}" class="text-white hover:text-kartred transition font-black uppercase tracking-wider inline-block">
                        Regístrate aquí
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>