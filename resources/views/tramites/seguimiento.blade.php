<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Estado de Trámite - Victorino Elorz</title>
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
                <a href="{{ route('seguimiento.form') }}" class="hover:text-red-600 transition tracking-tighter uppercase font-black">SEGUIMIENTO</a>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-16 px-6">
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('seguimiento.form') }}" class="flex items-center gap-2 text-slate-500 hover:text-red-600 font-bold transition-all uppercase text-xs tracking-widest">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Nueva consulta
            </a>
            <span class="px-4 py-1.5 bg-white border border-slate-200 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                Expediente: {{ $tramite->numero_expediente }}
            </span>
        </div>

        <!-- Tarjeta de Estado Principal -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden mb-8">
            <div class="p-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div>
                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-widest mb-2 inline-block">
                            {{ $tramite->procedimientoTupa->nombre }}
                        </span>
                        <h2 class="text-3xl font-black text-slate-800 leading-tight">Estado del Trámite</h2>
                    </div>
                    
                    <div class="flex flex-col items-end">
                        <div class="flex items-center gap-3 px-6 py-3 rounded-2xl shadow-inner
                            @if($tramite->estado === 'Recibido') bg-blue-50 text-blue-700 border border-blue-100
                            @elseif($tramite->estado === 'En Revisión') bg-amber-50 text-amber-700 border border-amber-100
                            @elseif($tramite->estado === 'Aprobado') bg-emerald-50 text-emerald-700 border border-emerald-100
                            @elseif($tramite->estado === 'Rechazado') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-slate-50 text-slate-700 border border-slate-100 @endif">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75
                                    @if($tramite->estado === 'Recibido') bg-blue-400
                                    @elseif($tramite->estado === 'En Revisión') bg-amber-400
                                    @elseif($tramite->estado === 'Aprobado') bg-emerald-400
                                    @else bg-slate-400 @endif"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3
                                    @if($tramite->estado === 'Recibido') bg-blue-600
                                    @elseif($tramite->estado === 'En Revisión') bg-amber-600
                                    @elseif($tramite->estado === 'Aprobado') bg-emerald-600
                                    @else bg-slate-600 @endif"></span>
                            </span>
                            <span class="text-lg font-black uppercase tracking-tighter">{{ $tramite->estado }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Fecha de Inicio</p>
                        <p class="text-lg font-bold text-slate-800">{{ $tramite->fecha_inicio->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Fecha Límite</p>
                        <p class="text-lg font-bold text-slate-800">{{ $tramite->fecha_limite ? $tramite->fecha_limite->format('d/m/Y') : 'Pendiente' }}</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Días Restantes</p>
                        <p class="text-lg font-bold @if($tramite->estaVencido()) text-rose-600 @else text-slate-800 @endif">
                            @if($tramite->fecha_limite)
                                {{ $tramite->fecha_limite->diffInDays(now()) }} días
                            @else
                                --
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50/50 p-8 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4 text-sm font-medium text-slate-500">
                    <span class="material-symbols-outlined text-blue-900">domain</span>
                    <span>Oficina Responsable: <span class="font-bold text-slate-800">{{ $tramite->procedimientoTupa->departamento_responsable }}</span></span>
                </div>
                <button onclick="window.print()" class="flex items-center gap-2 text-blue-900 hover:text-red-600 font-bold transition-all uppercase text-[10px] tracking-widest">
                    <span class="material-symbols-outlined text-sm">print</span> Imprimir Cargo
                </button>
            </div>
        </div>

        <!-- Historial de Movimientos -->
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-10">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2 uppercase tracking-tighter">
                <span class="material-symbols-outlined text-blue-900">history</span>
                Historial de Movimientos
            </h3>
            
            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                @foreach($tramite->movimientos as $mov)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icono central -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="material-symbols-outlined text-sm">check</span>
                    </div>
                    <!-- Contenido -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:bg-white group-hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between space-x-2 mb-1">
                            <div class="font-black text-slate-800 uppercase text-xs">{{ $mov->estado_nuevo }}</div>
                            <time class="font-bold text-[10px] text-blue-600">{{ $mov->fecha_movimiento->format('d/m/Y H:i') }}</time>
                        </div>
                        <div class="text-slate-500 text-sm italic">"{{ $mov->comentarios }}"</div>
                    </div>
                </div>
                @endforeach
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
  </div>
</x-app-layout>