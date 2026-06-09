<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Nueva Contraseña</title>
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
                Nueva <span class="text-kartred">Contraseña</span>
            </h2>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Email del Piloto</label>
                    <input id="email" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <div>
                    <label for="password" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Nueva Contraseña</label>
                    <input id="password" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <div>
                    <label for="password_confirmation" class="block uppercase text-xs font-black text-gray-500 mb-2 tracking-widest">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="w-full bg-black border border-zinc-700 rounded p-3 text-white focus:ring-kartred focus:border-kartred outline-none transition" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-kartred text-sm font-bold" />
                </div>

                <button type="submit" class="w-full bg-kartred hover:bg-red-700 text-white font-black py-4 rounded uppercase transition tracking-wider shadow-lg shadow-kartred/20">
                    Restablecer Contraseña
                </button>
            </form>
        </div>
    </main>
</body>
</html>