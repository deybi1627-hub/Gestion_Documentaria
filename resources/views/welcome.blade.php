<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>I.E.S.P.P. "Hno. Victorino Elorz Goicoechea" - Portal de Trámites</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 font-sans">
        <!-- Navbar -->
        <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-10 w-auto fill-current text-brand-700" />
                        <div class="flex flex-col">
                            <span class="font-black text-lg text-brand-900 leading-none tracking-tighter">VICTORINO ELORZ</span>
                            <span class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">Sullana - Piura</span>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#inicio" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Inicio</a>
                        <a href="#documentos" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Documentos</a>
                        <a href="{{ route('seguimiento.form') }}" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Seguimiento</a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-brand-900 text-white rounded-xl text-sm font-bold hover:bg-brand-800 transition-all shadow-lg shadow-brand-900/20">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-brand-900 hover:text-brand-700">Ingresar</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-brand-900 text-white rounded-xl text-sm font-bold hover:bg-brand-800 transition-all shadow-lg shadow-brand-900/20">
                                Registrarse
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="inicio" class="pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-widest mb-8 border border-brand-100">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                            </span>
                            Portal de Transparencia e Institucional
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] mb-8">
                            Formación Docente <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-700 via-brand-600 to-blue-500 italic">de Alto Nivel</span>
                        </h1>
                        <p class="text-xl text-slate-600 mb-10 max-w-lg leading-relaxed font-medium">
                            "Hno. Victorino Elorz Goicoechea" promueve la investigación y la innovación para transformar la práctica educativa.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#documentos" class="px-8 py-4 bg-brand-900 text-white rounded-2xl font-bold text-lg hover:bg-brand-800 transition-all shadow-xl shadow-brand-900/25 flex items-center justify-center group">
                                Consultar Documentos
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </a>
                            <a href="{{ route('seguimiento.form') }}" class="px-8 py-4 bg-slate-50 text-slate-700 rounded-2xl font-bold text-lg hover:bg-slate-100 transition-all flex items-center justify-center border border-slate-200">
                                Seguimiento de Trámites
                            </a>
                        </div>
                    </div>
                    <div class="mt-20 lg:mt-0 relative">
                        <!-- Search Portal Preview -->
                        <div class="bg-brand-900 p-8 rounded-[2.5rem] shadow-2xl border-8 border-brand-800/50">
                            <div class="mb-6">
                                <h3 class="text-2xl font-black text-white mb-2">Buscador Oficial</h3>
                                <p class="text-brand-200 text-sm">Encuentra resoluciones, oficios y directivas.</p>
                            </div>
                            <form action="{{ route('documentos.index') }}" method="GET" class="space-y-4">
                                <div class="relative">
                                    <select name="tipo" class="w-full bg-brand-800/50 text-white border-2 border-brand-700 rounded-2xl px-5 py-4 font-bold focus:ring-4 focus:ring-brand-500 transition-all appearance-none cursor-pointer">
                                        <option value="">Todas las categorías</option>
                                        <option value="Oficio">Oficios</option>
                                        <option value="TUPA">TUPA</option>
                                        <option value="Directiva">Directivas</option>
                                        <option value="Resolución">Resoluciones</option>
                                    </select>
                                    <div class="absolute right-5 top-5 pointer-events-none">
                                        <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                <input type="text" name="search" placeholder="Título o palabra clave..." class="w-full bg-white text-slate-900 border-none rounded-2xl px-5 py-4 font-bold placeholder-slate-400 focus:ring-4 focus:ring-brand-500 transition-all">
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white font-black py-5 rounded-2xl shadow-xl transition-all active:scale-[0.98] uppercase tracking-widest flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    Consultar Portal
                                </button>
                            </form>
                        </div>
                        
                        <!-- Decorative element -->
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Documents Section -->
        <section id="documentos" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                    <div>
                        <h2 class="text-4xl font-black text-slate-900 mb-4 flex items-center gap-4">
                            <span class="w-12 h-1 bg-brand-600 rounded-full"></span>
                            Últimas Publicaciones
                        </h2>
                        <p class="text-slate-500 font-medium text-lg">Documentos oficiales y normativas de la institución.</p>
                    </div>
                    @auth
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'secre')
                            <a href="{{ route('documentos.create') }}" class="flex items-center gap-2 bg-white text-brand-900 border-2 border-brand-900/10 px-6 py-3 rounded-xl font-bold hover:bg-brand-50 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Publicar Documento
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="grid gap-4">
                    @forelse($documentos as $doc)
                        <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300 flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="flex gap-6 items-start flex-1">
                                <div class="bg-slate-50 text-slate-400 group-hover:bg-brand-50 group-hover:text-brand-600 p-5 rounded-2xl transition-colors">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                        <span class="px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                                            {{ $doc->tipo }}
                                        </span>
                                        <span class="text-[11px] font-bold text-slate-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ \Carbon\Carbon::parse($doc->fecha_publicacion)->format('d M, Y') }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-brand-900 transition-colors">{{ $doc->titulo }}</h3>
                                    @if($doc->descripcion)
                                        <p class="text-slate-500 text-sm mt-2 line-clamp-1 font-medium">{{ $doc->descripcion }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <a href="{{ asset('storage/' . $doc->archivo_path) }}" target="_blank" class="flex-1 md:flex-none flex items-center justify-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-brand-600 transition-all shadow-lg text-sm uppercase tracking-tighter">
                                    Ver Documento
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>

                                @auth
                                    @can('admin-tramites')
                                        <form action="{{ route('documentos.destroy', $doc) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este documento oficial?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-4 text-red-500 bg-red-50 hover:bg-red-100 rounded-2xl transition-colors border border-red-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24 bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
                            <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <p class="text-slate-400 font-bold text-xl uppercase tracking-tighter">No se encontraron documentos.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-12">
                    {{ $documentos->links() }}
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-24 bg-brand-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                    <div>
                        <p class="text-5xl font-black text-white mb-3">100%</p>
                        <div class="h-1 w-12 bg-blue-500 mx-auto mb-4 rounded-full"></div>
                        <p class="text-brand-300 text-xs font-black uppercase tracking-[0.2em]">Transparencia</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black text-white mb-3">24/7</p>
                        <div class="h-1 w-12 bg-blue-500 mx-auto mb-4 rounded-full"></div>
                        <p class="text-brand-300 text-xs font-black uppercase tracking-[0.2em]">Disponibilidad</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black text-white mb-3">+{{ $documentos->total() }}</p>
                        <div class="h-1 w-12 bg-blue-500 mx-auto mb-4 rounded-full"></div>
                        <p class="text-brand-300 text-xs font-black uppercase tracking-[0.2em]">Documentos</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black text-white mb-3">Digital</p>
                        <div class="h-1 w-12 bg-blue-500 mx-auto mb-4 rounded-full"></div>
                        <p class="text-brand-300 text-xs font-black uppercase tracking-[0.2em]">Ecosistema</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-20 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">
                    <div>
                        <div class="flex items-center gap-3 mb-8">
                            <x-application-logo class="h-10 w-auto fill-current text-brand-700" />
                            <span class="font-black text-2xl text-brand-900 tracking-tighter">VICTORINO ELORZ</span>
                        </div>
                        <p class="text-slate-500 font-medium leading-relaxed">
                            Líderes en formación pedagógica, comprometidos con la excelencia académica y la innovación constante en la educación.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 uppercase tracking-widest text-sm mb-8">Información</h4>
                        <ul class="space-y-4 text-slate-500 font-bold">
                            <li><a href="#" class="hover:text-brand-600 transition-colors">Portal de Transparencia</a></li>
                            <li><a href="{{ route('seguimiento.form') }}" class="hover:text-brand-600 transition-colors">Seguimiento de Trámites</a></li>
                            <li><a href="https://teams.microsoft.com" target="_blank" class="hover:text-brand-600 transition-colors">Plataforma EVA</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 uppercase tracking-widest text-sm mb-8">Ubicación</h4>
                        <p class="text-slate-500 font-medium mb-4">
                            Urb. Santa Rosa - Calle María Auxiliadora Mz. 0917<br>
                            Sullana, Piura - Perú
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-brand-50 hover:text-brand-600 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em]">
                        © 2026 I.E.S.P.P. "Hno. Victorino Elorz Goicoechea"
                    </p>
                    <div class="flex gap-8">
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Desarrollado por AHPRA</span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
