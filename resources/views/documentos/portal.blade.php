<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Portal de Documentos - I.E.S.P.P. "Victorino Elorz"</title>
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
                <a href="https://teams.microsoft.com" target="_blank" class="hover:text-red-600 transition tracking-tighter uppercase font-black">PLATAFORMA EVA</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl hover:bg-blue-800">Panel de Control</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto py-12 px-6">
        <div class="mb-12">
            <h2 class="text-4xl font-black text-slate-800 mb-8 flex items-center gap-3">
                <span class="w-2 h-10 bg-blue-900 rounded-full"></span>
                PORTAL DE DOCUMENTOS
            </h2>

            <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
                <form action="{{ route('documentos.portal') }}" method="GET" class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Categoría</label>
                        <select name="tipo" class="w-full bg-slate-50 text-slate-800 px-4 py-3 rounded-xl border-slate-200 font-bold focus:ring-4 focus:ring-red-500">
                            <option value="">Todas las categorías</option>
                            <option value="Oficio" {{ request('tipo') == 'Oficio' ? 'selected' : '' }}>Oficios</option>
                            <option value="TUPA" {{ request('tipo') == 'TUPA' ? 'selected' : '' }}>TUPA</option>
                            <option value="Directiva" {{ request('tipo') == 'Directiva' ? 'selected' : '' }}>Directivas</option>
                            <option value="Resolución" {{ request('tipo') == 'Resolución' ? 'selected' : '' }}>Resoluciones</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Búsqueda</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Título o palabra clave..." 
                               class="w-full bg-slate-50 text-slate-800 px-4 py-3 rounded-xl border-slate-200 font-bold focus:ring-4 focus:ring-red-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-black py-3 rounded-xl shadow-lg transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">search</span> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid gap-6">
            @forelse($documentos as $doc)
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex gap-4 items-start flex-1">
                        <div class="bg-blue-50 text-blue-900 p-4 rounded-2xl">
                            <span class="material-symbols-outlined text-4xl">description</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $doc->tipo }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">
                                    {{ \Carbon\Carbon::parse($doc->fecha_publicacion)->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mt-1 leading-tight">{{ $doc->titulo }}</h3>
                            <p class="text-slate-500 text-sm mt-2 font-medium">{{ $doc->descripcion }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ asset('storage/' . $doc->archivo_path) }}" target="_blank" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-lg uppercase text-sm tracking-tighter flex items-center gap-2">
                            Descargar <span class="material-symbols-outlined text-lg">download</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-slate-300 text-6xl mb-4">search_off</span>
                    <p class="text-slate-500 font-bold text-xl uppercase tracking-tighter">No se encontraron documentos.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $documentos->appends(request()->query())->links() }}
        </div>
    </main>

    <footer class="bg-slate-900 text-white py-12 border-t-8 border-red-600">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-xs font-black uppercase tracking-[0.3em] opacity-50">
                © 2026 I.E.S.P.P. "Hno. Victorino Elorz Goicoechea" — Portal de Archivos Digitales
            </p>
        </div>
    </footer>

</body>
</html>
