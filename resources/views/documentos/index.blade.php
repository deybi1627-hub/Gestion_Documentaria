<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>I.E.S.P.P. "Hno. Victorino Elorz Goicoechea" - Sullana</title>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

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
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Sullana - Piura</p>
                </div>
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

    <section class="bg-gradient-to-r from-[#003366] to-[#00509d] text-white py-16 px-6 shadow-inner">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-3xl md:text-4xl font-black mb-6 border-l-8 border-red-600 pl-4 uppercase">
                    Formación Inicial Docente de Alto Nivel
                </h1>
                <p class="text-lg leading-relaxed text-blue-50 mb-6 font-medium italic">
                    "Somos una institución que brinda formación inicial docente que promueve la investigación y la innovación para mejorar la práctica educativa..."
                </p>
                <div class="flex flex-wrap gap-4 mb-4">
                    <span class="bg-red-600 px-4 py-2 rounded-full text-sm font-bold shadow-lg tracking-tighter uppercase">Investigación</span>
                    <span class="bg-blue-800 px-4 py-2 rounded-full text-sm font-bold shadow-lg tracking-tighter uppercase">Innovación</span>
                </div>

            </div>
            
            <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 shadow-2xl">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">search</span> Buscar Documentos
                </h3>
                <form action="{{ route('documentos.index') }}" method="GET" class="space-y-4">
                    <select name="tipo" class="w-full text-gray-800 px-4 py-3 rounded-xl border-none font-bold focus:ring-4 focus:ring-red-500">
                        <option value="">Todas las categorías</option>
                        <option value="Oficio">Oficios</option>
                        <option value="TUPA">TUPA</option>
                        <option value="Directiva">Directivas</option>
                        <option value="Resolución">Resoluciones</option>
                    </select>
                    <input type="text" name="search" placeholder="Título o palabra clave..." class="w-full text-gray-800 px-4 py-3 rounded-xl border-none font-bold focus:ring-4 focus:ring-red-500">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl shadow-xl transition-transform active:scale-95 uppercase tracking-widest">
                        CONSULTAR PORTAL
                    </button>
                </form>
            </div>
        </div>
    </section>

    <main class="max-w-6xl mx-auto py-16 px-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-10 shadow-md font-bold rounded-r-lg text-left">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <h2 class="text-3xl font-black text-slate-800 mb-10 flex items-center gap-3 text-left">
            <span class="w-2 h-8 bg-red-600 rounded-full"></span>
            ÚLTIMAS PUBLICACIONES
        </h2>

        <div class="grid gap-6">
            @forelse($documentos as $doc)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex gap-4 items-start flex-1 text-left">
                        <div class="bg-red-50 text-red-600 p-4 rounded-2xl">
                            <span class="material-symbols-outlined text-4xl">description</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-black text-blue-600 uppercase tracking-widest">{{ $doc->tipo }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">
                                    {{ \Carbon\Carbon::parse($doc->fecha_publicacion)->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mt-1 leading-tight">{{ $doc->titulo }}</h3>
                            <p class="text-gray-500 text-sm mt-2 font-medium">{{ $doc->descripcion }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ asset('storage/' . $doc->archivo_path) }}" target="_blank" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-lg uppercase text-sm tracking-tighter">
                            Descargar <span class="material-symbols-outlined text-lg">download</span>
                        </a>

                        @auth
                            @if(auth()->user()->role == 'admin')
                                <form action="{{ route('documentos.destroy', $doc) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este documento oficial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition border border-red-100 shadow-sm flex items-center justify-center">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 w-full">
                    <span class="material-symbols-outlined text-gray-300 text-6xl mb-4">search_off</span>
                    <p class="text-gray-500 font-bold text-xl uppercase tracking-tighter">No se encontraron documentos.</p>
                </div>
            @endforelse
        </div>
        
        @if($totalDocumentos > 3)
            <div class="mt-12 text-center">
                <a href="{{ route('documentos.portal') }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-10 py-4 rounded-full font-black hover:bg-red-700 transition shadow-xl uppercase tracking-widest">
                    Ver todos los documentos <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        @endif
    </main>

    <footer class="bg-[#002147] text-white pt-16 pb-8 border-t-8 border-red-600">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 text-center md:text-left">
                
                <div class="space-y-4">
                    <h4 class="text-red-500 font-black uppercase tracking-widest text-sm flex items-center justify-center md:justify-start gap-2">
                        <span class="material-symbols-outlined">location_on</span> Ubicación
                    </h4>
                    
                    <div class="w-full h-48 rounded-2xl overflow-hidden shadow-lg border border-white/10">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.6373801262754!2d-80.69731462414167!3d-4.911163841648079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916d7bcfe733f4dd%3A0x6cdb0ddd80632f20!2sIESPP%20HNO.VICTORINO%20ELORZ%20GOICOECHEA%20SULLANA!5e0!3m2!1ses!2spe!4v1715610000000!5m2!1ses!2spe" 
                            class="w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <p class="text-blue-100 text-sm leading-relaxed font-bold italic">
                        Urb. Santa Rosa - Calle María Auxiliadora Mz. 0917<br>
                        Sullana, Piura - Perú
                    </p>
                </div>

                <div>
                    <h4 class="text-red-500 font-black mb-6 uppercase tracking-widest text-sm flex items-center justify-center md:justify-start gap-2">
                        <span class="material-symbols-outlined">contact_support</span> Contacto
                    </h4>
                    <div class="space-y-4 text-sm font-bold text-blue-100">
                        <p class="flex items-center justify-center md:justify-start gap-3">
                            <span class="material-symbols-outlined text-blue-400">call</span> 
                            +51 (073) 523298
                        </p>
                        <p class="flex items-center justify-center md:justify-start gap-3">
                            <span class="material-symbols-outlined text-blue-400 text-xs md:text-sm">mail</span> 
                            d.general@eespvictorinoelorzsullana.edu.pe
                        </p>
                    </div>
                </div>

                <div class="bg-white/5 p-8 rounded-3xl border border-white/10 flex flex-col justify-center items-center shadow-2xl">
                    <h4 class="text-red-500 font-black mb-4 uppercase tracking-widest text-sm flex items-center gap-2 text-center">
                        <span class="material-symbols-outlined">schedule</span> Horario de Atención
                    </h4>
                    <p class="text-white font-black text-2xl italic uppercase tracking-tighter">Lunes a Viernes</p>
                    <p class="text-blue-200 font-bold text-lg mt-1 tracking-tighter">8:00 AM — 3:00 PM</p>
                </div>
            </div>

            <div class="text-center pt-8 border-t border-white/10">
                <p class="text-[10px] text-blue-400 font-black uppercase tracking-[0.3em]">
                    © 2026 I.E.S.P.P. "Hno. Victorino Elorz Goicoechea" — Gestión de Archivos Digitales
                </p>
            </div>
        </div>
    </footer>

</body>
</html>