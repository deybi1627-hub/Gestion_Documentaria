<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Seguimiento de Trámites - Victorino Elorz</title>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <header class="bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 h-24 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('img/logo.png') }}" alt="Escudo" class="h-16 w-auto object-contain">
                <div class="h-12 w-px bg-gray-300 hidden md:block"></div>
                <div class="hidden md:block text-left">
                    <h2 class="text-[11px] font-extrabold text-blue-900 uppercase leading-none tracking-tighter">
                        Instituto de Educación Superior Pedagógico Público
                    </h2>
                    <h1 class="text-[14px] font-black text-red-600 uppercase tracking-tight">
                        "Hno. Victorino Elorz Goicoechea"
                    </h1>
                </div>
            </div>

            <nav class="hidden lg:flex gap-8 text-sm font-bold text-slate-700 items-center">
                <a href="{{ url('/') }}" class="hover:text-red-600 transition tracking-tighter uppercase">INICIO</a>
                <a href="{{ route('documentos.portal') }}" class="hover:text-red-600 transition tracking-tighter uppercase">DOCUMENTOS</a>
                <a href="{{ route('seguimiento.form') }}" class="hover:text-red-600 transition tracking-tighter uppercase">SEGUIMIENTO</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl hover:bg-blue-800">Panel de Control</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-20 px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-slate-800 mb-4 uppercase tracking-tighter">
                Consulta tu Expediente
            </h2>
            <p class="text-slate-500 font-medium text-lg">Realiza el seguimiento en tiempo real de tu trámite administrativo.</p>
        </div>

        <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('seguimiento.buscar') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                <div>
                    <label for="search" class="block text-xs font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest text-center">
                        Ingresa tu Número de Expediente o Nombre Completo
                    </label>
                    <div class="relative max-w-2xl mx-auto">
                        <span class="material-symbols-outlined absolute left-5 top-5 text-slate-400 text-3xl">search</span>
                        <input type="text" id="search" name="search"
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-[2rem] pl-16 pr-6 py-5 font-bold text-xl text-slate-700 focus:ring-4 focus:ring-red-500 focus:border-red-500 transition-all shadow-inner"
                               placeholder="Ej: EXP-2026-001 o Juan Perez..." required>
                    </div>
                </div>

                <div class="flex justify-center pt-2">
                    <button type="submit"
                            class="px-12 bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-full shadow-2xl shadow-red-600/30 transition-all active:scale-[0.98] uppercase tracking-widest flex items-center gap-3 text-lg">
                        <span class="material-symbols-outlined">manage_search</span>
                        Buscar Trámite
                    </button>
                </div>
            </form>

            @if(session('error'))
            <div class="mt-8 bg-red-50 border border-red-100 rounded-2xl p-4 flex items-center gap-3 text-red-600 font-bold text-sm">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </div>
            @endif
        </div>

        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">schedule</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Respuesta</p>
                <p class="text-sm font-bold text-slate-700 italic">24-48 horas hábiles</p>
            </div>
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">security</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Seguridad</p>
                <p class="text-sm font-bold text-slate-700 italic">Datos encriptados</p>
            </div>
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">info</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Soporte</p>
                <p class="text-sm font-bold text-slate-700 italic">Atención personalizada</p>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-white py-12 border-t-8 border-red-600">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-xs font-black uppercase tracking-[0.3em] opacity-50">
                © 2026 I.E.S.P.P. "Hno. Victorino Elorz Goicoechea" — Mesa de Partes Digital
            </p>
        </div>
    </footer>

</body>
</html>