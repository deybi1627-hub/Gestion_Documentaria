<x-public-layout title="Portal de Documentos - Victorino Elorz">

    <section class="text-white py-16 px-6 shadow-inner relative overflow-hidden"
        style="background: linear-gradient(to right, rgba(0,51,102,0.85), rgba(0,80,157,0.80)), url('{{ asset('img/pedagogico.jpeg') }}') center/cover no-repeat;">
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

    <!-- Paso a Paso Section -->
    <section class="py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 mb-4 flex items-center justify-center gap-4 tracking-tighter">
                    <span class="w-12 h-1 bg-red-600 rounded-full"></span>
                    Trámites Digitales en 3 Sencillos Pasos
                </h2>
                <p class="text-slate-500 font-medium text-lg max-w-2xl mx-auto">Gestiona tus trámites y expedientes de forma 100% digital, rápida y segura.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Decorative connecting line for md and up -->
                <div class="hidden md:block absolute top-1/2 left-[15%] right-[15%] h-0.5 bg-slate-200 -translate-y-1/2 z-0"></div>

                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 font-black text-2xl mb-6 shadow-inner relative">
                        <span class="material-symbols-outlined text-3xl">vpn_key</span>
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-md">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Acceso Seguro</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">
                        Crea tu cuenta institucional o inicia sesión de forma segura para acceder a tu panel de control privado.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 font-black text-2xl mb-6 shadow-inner relative">
                        <span class="material-symbols-outlined text-3xl">post_add</span>
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-md">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Registro de Trámite</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">
                        Selecciona tu procedimiento TUPA, completa la información requerida y adjunta tus requisitos en formato PDF.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 font-black text-2xl mb-6 shadow-inner relative">
                        <span class="material-symbols-outlined text-3xl">visibility</span>
                        <span class="absolute -top-2 -right-2 bg-emerald-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-md">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Monitoreo y Respuestas</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">
                        Realiza el seguimiento seguro de cada estado, movimiento u observaciones directamente en tu Dashboard.
                    </p>
                </div>
            </div>

            <div class="flex justify-center mt-12">
                <a href="{{ route('login') }}" class="px-10 py-5 bg-gradient-to-r from-[#003366] to-[#00509d] text-white font-black rounded-2xl shadow-xl shadow-[#003366]/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg">login</span>
                    Acceder a Mesa de Partes
                </a>
            </div>
        </div>
    </section>

    <!-- Procedimientos TUPA Section -->
    <section class="py-24 bg-white border-t border-slate-100" x-data="{ activeProcedimiento: null }">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 mb-4 flex items-center justify-center gap-4 tracking-tighter">
                    <span class="w-12 h-1 bg-red-600 rounded-full"></span>
                    Procedimientos Administrativos Frecuentes (TUPA)
                </h2>
                <p class="text-slate-500 font-medium text-lg max-w-2xl mx-auto">Conoce los costos, tiempos de resolución y requisitos de los trámites más comunes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Item 1: Certificado de Estudios -->
                <div class="border rounded-[2rem] p-6 transition-all duration-300 cursor-pointer flex flex-col justify-between"
                     :class="activeProcedimiento === 1 ? 'border-red-500 bg-red-50/20 shadow-lg' : 'border-slate-100 bg-white hover:border-slate-300 hover:shadow-md'"
                     @click="activeProcedimiento = activeProcedimiento === 1 ? null : 1">
                    <div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors animate-none"
                             :class="activeProcedimiento === 1 ? 'bg-red-600 text-white' : 'bg-red-50 text-red-600'">
                            <span class="material-symbols-outlined">school</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2 leading-snug">Certificado de Estudios</h3>
                        <p class="text-slate-500 text-xs font-medium mb-4 line-clamp-2">Documento oficial que acredita las calificaciones académicas obtenidas.</p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-xs font-bold">
                        <span class="text-slate-400">Costo: <span class="text-red-600 font-black">S/. 15.00</span></span>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">5 días</span>
                    </div>
                </div>

                <!-- Item 2: Duplicado de Carné -->
                <div class="border rounded-[2rem] p-6 transition-all duration-300 cursor-pointer flex flex-col justify-between"
                     :class="activeProcedimiento === 2 ? 'border-blue-500 bg-blue-50/20 shadow-lg' : 'border-slate-100 bg-white hover:border-slate-300 hover:shadow-md'"
                     @click="activeProcedimiento = activeProcedimiento === 2 ? null : 2">
                    <div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors animate-none"
                             :class="activeProcedimiento === 2 ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600'">
                            <span class="material-symbols-outlined">badge</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2 leading-snug">Duplicado de Carné</h3>
                        <p class="text-slate-500 text-xs font-medium mb-4 line-clamp-2">Emisión de un nuevo carné por motivo de pérdida, robo o deterioro.</p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-xs font-bold">
                        <span class="text-slate-400">Costo: <span class="text-red-600 font-black">S/. 10.00</span></span>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">3 días</span>
                    </div>
                </div>

                <!-- Item 3: Título Profesional -->
                <div class="border rounded-[2rem] p-6 transition-all duration-300 cursor-pointer flex flex-col justify-between"
                     :class="activeProcedimiento === 3 ? 'border-purple-500 bg-purple-50/20 shadow-lg' : 'border-slate-100 bg-white hover:border-slate-300 hover:shadow-md'"
                     @click="activeProcedimiento = activeProcedimiento === 3 ? null : 3">
                    <div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors animate-none"
                             :class="activeProcedimiento === 3 ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-600'">
                            <span class="material-symbols-outlined">workspace_premium</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2 leading-snug">Título Profesional</h3>
                        <p class="text-slate-500 text-xs font-medium mb-4 line-clamp-2">Proceso de titulación profesional oficial una vez egresado satisfactoriamente.</p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-xs font-bold">
                        <span class="text-slate-400">Costo: <span class="text-red-600 font-black">S/. 150.00</span></span>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">30 días</span>
                    </div>
                </div>

                <!-- Item 4: Constancia de Matrícula -->
                <div class="border rounded-[2rem] p-6 transition-all duration-300 cursor-pointer flex flex-col justify-between"
                     :class="activeProcedimiento === 4 ? 'border-emerald-500 bg-emerald-50/20 shadow-lg' : 'border-slate-100 bg-white hover:border-slate-300 hover:shadow-md'"
                     @click="activeProcedimiento = activeProcedimiento === 4 ? null : 4">
                    <div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors animate-none"
                             :class="activeProcedimiento === 4 ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-600'">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2 leading-snug">Constancia de Matrícula</h3>
                        <p class="text-slate-500 text-xs font-medium mb-4 line-clamp-2">Documento que acredita la matrícula vigente en el ciclo académico actual.</p>
                    </div>
                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-xs font-bold">
                        <span class="text-slate-400">Costo: <span class="text-emerald-700 font-black">Gratuito</span></span>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">24 horas</span>
                    </div>
                </div>
            </div>

            <!-- Requirements Detail Panel -->
            <div class="mt-8 transition-all duration-500 overflow-hidden" x-show="activeProcedimiento !== null" x-transition>
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 relative">
                    <!-- Close Button -->
                    <button @click="activeProcedimiento = null" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Certificado de Estudios Detail -->
                    <div x-show="activeProcedimiento === 1">
                        <h4 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-red-600">school</span>
                            Requisitos para Certificado de Estudios
                        </h4>
                        <ul class="space-y-3 text-slate-600 font-medium text-sm text-left">
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-red-600 text-lg">check_circle</span> Solicitud dirigida al Director del Instituto (en formato PDF).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-red-600 text-lg">check_circle</span> Copia legible del Documento Nacional de Identidad (DNI).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-red-600 text-lg">check_circle</span> Comprobante de pago de S/. 15.00 registrado en el portal.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-red-600 text-lg">check_circle</span> Dos fotos actuales tamaño carné con fondo blanco (se entregan al recoger el documento).</li>
                        </ul>
                    </div>

                    <!-- Duplicado de Carné Detail -->
                    <div x-show="activeProcedimiento === 2">
                        <h4 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">badge</span>
                            Requisitos para Duplicado de Carné Institucional
                        </h4>
                        <ul class="space-y-3 text-slate-600 font-medium text-sm text-left">
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-blue-600 text-lg">check_circle</span> Solicitud de duplicado detallando el motivo (pérdida, robo o deterioro).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-blue-600 text-lg">check_circle</span> Copia del DNI.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-blue-600 text-lg">check_circle</span> Comprobante de pago del derecho de trámite (S/. 10.00).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-blue-600 text-lg">check_circle</span> Foto digital tamaño carné con fondo blanco (formato JPG/PNG para la credencial).</li>
                        </ul>
                    </div>

                    <!-- Título Profesional Detail -->
                    <div x-show="activeProcedimiento === 3">
                        <h4 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-purple-600">workspace_premium</span>
                            Requisitos para Título Profesional Pedagógico
                        </h4>
                        <ul class="space-y-3 text-slate-600 font-medium text-sm text-left">
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-purple-600 text-lg">check_circle</span> Constancia oficial de egresado (sin deudas académicas ni administrativas).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-purple-600 text-lg">check_circle</span> Copia legalizada de DNI y partida de nacimiento.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-purple-600 text-lg">check_circle</span> Acta oficial del Examen de Suficiencia Profesional o sustentación aprobada.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-purple-600 text-lg">check_circle</span> Pago de derecho de titulación (S/. 150.00).</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-purple-600 text-lg">check_circle</span> Cuatro fotos tamaño pasaporte en traje formal, fondo blanco.</li>
                        </ul>
                    </div>

                    <!-- Constancia de Matrícula Detail -->
                    <div x-show="activeProcedimiento === 4">
                        <h4 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600">receipt_long</span>
                            Requisitos para Constancia de Matrícula
                        </h4>
                        <ul class="space-y-3 text-slate-600 font-medium text-sm text-left">
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Solicitud de constancia (Gratuita) registrada por Mesa de Partes Digital.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Ficha de matrícula académica correspondiente al ciclo vigente.</li>
                            <li class="flex items-start gap-2.5"><span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span> Estar al día en los aportes y cuotas correspondientes de la institución.</li>
                        </ul>
                    </div>
                </div>
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

    <!-- Ecosistema Section -->
    <section class="py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 mb-4 flex items-center justify-center gap-4 tracking-tighter">
                    <span class="w-12 h-1 bg-red-600 rounded-full"></span>
                    Ecosistema Institucional
                </h2>
                <p class="text-slate-500 font-medium text-lg max-w-2xl mx-auto text-center">Enlaces rápidos y plataformas del Instituto de Educación Superior Pedagógico.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1: EVA -->
                <a href="https://teams.microsoft.com" target="_blank" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl">computer</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-red-600 mb-2 transition-colors text-left">Plataforma EVA</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed text-left">
                            Aulas virtuales, videoconferencias, foros y herramientas colaborativas de Microsoft Teams.
                        </p>
                    </div>
                    <span class="text-red-600 font-bold text-xs uppercase tracking-widest mt-6 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Acceder a EVA →
                    </span>
                </a>

                <!-- Card 2: Admision -->
                <a href="{{ route('documentos.portal', ['tipo' => 'TUPA']) }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl">campaign</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-red-600 mb-2 transition-colors text-left">Admisión 2026</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed text-left">
                            Toda la información sobre el examen de ingreso, vacantes, cronograma y reglamentos vigentes.
                        </p>
                    </div>
                    <span class="text-red-600 font-bold text-xs uppercase tracking-widest mt-6 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Ver Información →
                    </span>
                </a>

                <!-- Card 3: Biblioteca -->
                <a href="{{ route('documentos.portal') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl">local_library</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-red-600 mb-2 transition-colors text-left">Portal de Archivos</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed text-left">
                            Acceso público a directivas, resoluciones institucionales, TUPA e investigaciones pedagógicas oficiales.
                        </p>
                    </div>
                    <span class="text-red-600 font-bold text-xs uppercase tracking-widest mt-6 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Explorar Portal →
                    </span>
                </a>

                <!-- Card 4: Soporte -->
                <a href="{{ route('login') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl">support_agent</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-red-600 mb-2 transition-colors text-left">Soporte y Ayuda</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed text-left">
                            Soporte técnico para recuperación de contraseñas, problemas con vouchers o dudas de Mesa de Partes.
                        </p>
                    </div>
                    <span class="text-red-600 font-bold text-xs uppercase tracking-widest mt-6 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Solicitar Ayuda →
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white border-t border-slate-100" x-data="{ activeFAQ: null }">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 mb-4 flex items-center justify-center gap-4 tracking-tighter">
                    <span class="w-12 h-1 bg-red-600 rounded-full"></span>
                    Preguntas Frecuentes
                </h2>
                <p class="text-slate-500 font-medium text-lg text-center">Resuelve tus dudas sobre trámites, plazos y seguridad documental.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300"
                     :class="activeFAQ === 1 ? 'border-red-300 shadow-md bg-slate-50/50' : 'bg-white hover:border-slate-200'">
                    <button @click="activeFAQ = activeFAQ === 1 ? null : 1" class="w-full px-8 py-6 text-left flex justify-between items-center font-bold text-slate-800 text-lg">
                        <span>¿Por qué el seguimiento de trámites ahora requiere inicio de sesión?</span>
                        <span class="material-symbols-outlined transition-transform duration-300 text-slate-400"
                              :class="activeFAQ === 1 ? 'rotate-180 text-red-600' : ''">
                            expand_more
                        </span>
                    </button>
                    <div class="px-8 pb-6 text-slate-500 font-medium text-sm leading-relaxed text-left" x-show="activeFAQ === 1" x-transition>
                        Para garantizar la **confidencialidad de tu información personal**, resoluciones, comprobantes y vouchers adjuntos. Ahora toda la información sensible está protegida bajo un sistema seguro accesible únicamente para ti y los funcionarios autorizados del instituto.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300"
                     :class="activeFAQ === 2 ? 'border-red-300 shadow-md bg-slate-50/50' : 'bg-white hover:border-slate-200'">
                    <button @click="activeFAQ = activeFAQ === 2 ? null : 2" class="w-full px-8 py-6 text-left flex justify-between items-center font-bold text-slate-800 text-lg">
                        <span>¿En qué formatos debo adjuntar mis requisitos y comprobantes?</span>
                        <span class="material-symbols-outlined transition-transform duration-300 text-slate-400"
                              :class="activeFAQ === 2 ? 'rotate-180 text-red-600' : ''">
                            expand_more
                        </span>
                    </button>
                    <div class="px-8 pb-6 text-slate-500 font-medium text-sm leading-relaxed text-left" x-show="activeFAQ === 2" x-transition>
                        Por motivos de seguridad informática y estandarización institucional, todos los documentos requeridos del trámite deben presentarse **estrictamente en formato PDF**. Para los vouchers o comprobantes de pago, el sistema permite imágenes (`.jpg`, `.jpeg`, `.png`) o documentos `.pdf`. El tamaño máximo es de **2MB** por archivo.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300"
                     :class="activeFAQ === 3 ? 'border-red-300 shadow-md bg-slate-50/50' : 'bg-white hover:border-slate-200'">
                    <button @click="activeFAQ = activeFAQ === 3 ? null : 3" class="w-full px-8 py-6 text-left flex justify-between items-center font-bold text-slate-800 text-lg">
                        <span>¿Cómo sé si mi trámite ha sido observado o aprobado?</span>
                        <span class="material-symbols-outlined transition-transform duration-300 text-slate-400"
                              :class="activeFAQ === 3 ? 'rotate-180 text-red-600' : ''">
                            expand_more
                        </span>
                    </button>
                    <div class="px-8 pb-6 text-slate-500 font-medium text-sm leading-relaxed text-left" x-show="activeFAQ === 3" x-transition>
                        Al ingresar a tu **Panel de Control (Dashboard)**, dirígete a la sección "Mis Trámites". Allí podrás ver el estado de tu expediente (Recibido, En Revisión, Aprobado, Rechazado o Finalizado) y, al hacer clic en "Ver Detalles", visualizarás el historial completo con comentarios y derivaciones entre oficinas en tiempo real.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-slate-100 rounded-3xl overflow-hidden transition-all duration-300"
                     :class="activeFAQ === 4 ? 'border-red-300 shadow-md bg-slate-50/50' : 'bg-white hover:border-slate-200'">
                    <button @click="activeFAQ = activeFAQ === 4 ? null : 4" class="w-full px-8 py-6 text-left flex justify-between items-center font-bold text-slate-800 text-lg">
                        <span>¿Cómo realizo el pago por derecho de trámite de un procedimiento?</span>
                        <span class="material-symbols-outlined transition-transform duration-300 text-slate-400"
                              :class="activeFAQ === 4 ? 'rotate-180 text-red-600' : ''">
                            expand_more
                        </span>
                    </button>
                    <div class="px-8 pb-6 text-slate-500 font-medium text-sm leading-relaxed text-left" x-show="activeFAQ === 4" x-transition>
                        Si tu procedimiento TUPA tiene costo, el sistema creará un registro de pago pendiente al crear tu trámite. Deberás abonar el monto correspondiente en las cuentas del Instituto o en Caja, y luego adjuntar el voucher desde la sección "Información Financiera" en los detalles de tu trámite. El área de Finanzas validará tu pago en un plazo aproximado de 24 horas hábiles.
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>