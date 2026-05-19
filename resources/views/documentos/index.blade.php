<x-public-layout title="Portal de Documentos - Victorino Elorz">

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

</x-public-layout>