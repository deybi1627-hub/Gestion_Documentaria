<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-2">Crear Cuenta</h2>
        <p class="text-slate-500 font-medium text-sm">Únete para gestionar tus trámites institucionales.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nombre Completo</label>
            <input id="name" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ej. Juan Pérez" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Correo Electrónico</label>
            <input id="email" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Contraseña</label>
            <input id="password" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-bold focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder:text-slate-400 placeholder:font-medium" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-700/30 transition-transform active:scale-[0.98] uppercase tracking-widest flex justify-center items-center gap-2">
                Registrarse
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </button>
        </div>
        
        <p class="text-center text-sm font-medium text-slate-500 mt-6">
            ¿Ya tienes una cuenta? 
            <a href="{{ route('login') }}" class="font-bold text-red-600 hover:text-red-700 transition-colors border-b border-transparent hover:border-red-700 pb-0.5">
                Ingresa aquí
            </a>
        </p>
    </form>
</x-guest-layout>
