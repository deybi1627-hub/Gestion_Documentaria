<header class="bg-white border-b sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 h-24 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <img src="{{ asset('img/logo.png') }}" alt="Escudo" class="h-16 w-auto object-contain">
                <div class="h-12 w-px bg-gray-300 hidden md:block"></div>
                <div class="hidden md:block text-left">
                    <h2 class="text-[11px] font-extrabold text-blue-900 uppercase leading-none tracking-tighter">
                        Instituto de Educación Superior Pedagógico Público
                    </h2>
                    <h1 class="text-[14px] font-black text-red-600 uppercase tracking-tight">
                        "Hno. Victorino Elorz Goicoechea"
                    </h1>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Sullana - Piura</p>
                </div>
            </a>
        </div>

        <nav class="hidden lg:flex gap-8 text-sm font-bold text-slate-700 items-center">
            <a href="{{ url('/') }}" class="hover:text-red-600 transition tracking-tighter uppercase">INICIO</a>
            <a href="{{ route('documentos.portal') }}" class="hover:text-red-600 transition tracking-tighter uppercase">DOCUMENTOS</a>
            <a href="{{ route('seguimiento.form') }}" class="hover:text-red-600 transition tracking-tighter uppercase">SEGUIMIENTO</a>
            <a href="https://teams.microsoft.com" target="_blank" class="hover:text-red-600 transition tracking-tighter uppercase font-black">PLATAFORMA EVA</a>
            
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl hover:bg-blue-800 transition shadow-md tracking-tighter uppercase">Panel de Control</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline uppercase text-xs font-black ml-2">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="border border-blue-900 text-blue-900 px-5 py-2.5 rounded-xl hover:bg-blue-50 transition tracking-tighter uppercase flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">lock</span> Ingresar
                </a>
            @endauth
        </nav>
    </div>
</header>
