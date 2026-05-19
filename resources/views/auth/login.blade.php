<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-2">Bienvenido de nuevo</h2>
        <p class="text-slate-500 font-medium text-sm">Ingresa tus credenciales para acceder al sistema.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Correo Electrónico</label>
            <input id="email" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 ml-1">
                <label for="password" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-blue-600 hover:text-red-600 transition-colors" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <input id="password" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center justify-center">
                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 transition-all cursor-pointer" name="remember">
                </div>
                <span class="ms-3 text-sm font-bold text-slate-600 group-hover:text-slate-900 transition-colors">Mantener sesión iniciada</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-red-600/30 transition-transform active:scale-[0.98] uppercase tracking-widest flex justify-center items-center gap-2">
                Iniciar Sesión
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
        
        @if (Route::has('register'))
            <p class="text-center text-sm font-medium text-slate-500 mt-8">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:text-red-600 transition-colors border-b border-transparent hover:border-red-600 pb-0.5">
                    Regístrate aquí
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
