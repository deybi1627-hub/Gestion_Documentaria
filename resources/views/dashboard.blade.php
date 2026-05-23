<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                {{ __('Panel de Control') }}
            </h2>
            
            <div class="flex flex-wrap items-center gap-3">
                {{-- Role Badge & Name --}}
                <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-black uppercase
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'secre') bg-brand-100 text-brand-700
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block pr-2">
                        <p class="text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-tight mt-0.5">
                            @if(Auth::user()->role === 'admin') Administrador
                            @elseif(Auth::user()->role === 'secre') Secretario/a
                            @else Ciudadano @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @php $isAdmin = in_array(Auth::user()->role, ['admin', 'secre']); @endphp

            <!-- ===== PUNTO 2: Tarjetas clicables con alerta de vencidos ===== -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Activos -->
                <a href="{{ $isAdmin ? route('admin.tramites.index', ['estado' => 'Recibido']) : route('tramites.index') }}"
                   class="group bg-white overflow-hidden shadow-sm rounded-2xl border border-blue-100 hover:shadow-lg hover:border-blue-300 transition-all duration-300 hover:-translate-y-1 block">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-blue-300 group-hover:text-blue-500 transition-colors mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black text-slate-900">{{ $counts['activos'] }}</p>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Activos</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">En proceso de revisión</p>
                        </div>
                        <div class="mt-4 h-1 w-full bg-blue-100 rounded-full">
                            <div class="h-1 bg-blue-500 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                </a>

                <!-- Completados -->
                <a href="{{ $isAdmin ? route('admin.tramites.index', ['estado' => 'Aprobado']) : route('tramites.index') }}"
                   class="group bg-white overflow-hidden shadow-sm rounded-2xl border border-emerald-100 hover:shadow-lg hover:border-emerald-300 transition-all duration-300 hover:-translate-y-1 block">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-emerald-300 group-hover:text-emerald-500 transition-colors mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black text-slate-900">{{ $counts['completados'] }}</p>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Completados</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Aprobados o finalizados</p>
                        </div>
                        <div class="mt-4 h-1 w-full bg-emerald-100 rounded-full">
                            <div class="h-1 bg-emerald-500 rounded-full" style="width: 80%"></div>
                        </div>
                    </div>
                </a>

                <!-- Vencidos — se pone ROJO si hay vencidos -->
                @if($isAdmin)
                <a href="{{ route('admin.tramites.index') }}"
                @else
                <div
                @endif
                   class="group overflow-hidden shadow-sm rounded-2xl border transition-all duration-300 hover:-translate-y-1 block
                       {{ $counts['vencidos'] > 0
                           ? 'bg-rose-600 border-rose-700 hover:shadow-rose-200 hover:shadow-lg'
                           : 'bg-white border-slate-100 hover:shadow-lg hover:border-rose-200' }}">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform
                                {{ $counts['vencidos'] > 0 ? 'bg-rose-700 text-white' : 'bg-rose-50 text-rose-600' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            @if($counts['vencidos'] > 0)
                            <span class="px-2 py-1 bg-rose-700 text-rose-100 rounded-lg text-[10px] font-black uppercase tracking-widest animate-pulse">¡Urgente!</span>
                            @else
                            <svg class="w-4 h-4 text-rose-300 group-hover:text-rose-500 transition-colors mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            @endif
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black {{ $counts['vencidos'] > 0 ? 'text-white' : 'text-slate-900' }}">{{ $counts['vencidos'] }}</p>
                            <p class="text-sm font-bold uppercase tracking-widest mt-1 {{ $counts['vencidos'] > 0 ? 'text-rose-200' : 'text-slate-500' }}">Vencidos</p>
                            <p class="text-xs font-medium mt-1 {{ $counts['vencidos'] > 0 ? 'text-rose-300' : 'text-slate-400' }}">
                                {{ $counts['vencidos'] > 0 ? 'Requieren atención inmediata' : 'Todo al día ✓' }}
                            </p>
                        </div>
                        <div class="mt-4 h-1 w-full rounded-full {{ $counts['vencidos'] > 0 ? 'bg-rose-700' : 'bg-rose-100' }}">
                            <div class="h-1 rounded-full {{ $counts['vencidos'] > 0 ? 'bg-rose-300' : 'bg-rose-400' }}" style="width: {{ $counts['vencidos'] > 0 ? '100' : '5' }}%"></div>
                        </div>
                    </div>
                @if($isAdmin)
                </a>
                @else
                </div>
                @endif

                <!-- Archivados -->
                <a href="{{ $isAdmin ? route('archivos.index') : '#' }}"
                   class="group bg-white overflow-hidden shadow-sm rounded-2xl border border-purple-100 hover:shadow-lg hover:border-purple-300 transition-all duration-300 hover:-translate-y-1 block">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-purple-300 group-hover:text-purple-500 transition-colors mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black text-slate-900">{{ $counts['archivos'] }}</p>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Archivados</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Expedientes en archivo</p>
                        </div>
                        <div class="mt-4 h-1 w-full bg-purple-100 rounded-full">
                            <div class="h-1 bg-purple-500 rounded-full" style="width: 40%"></div>
                        </div>
                    </div>
                </a>

            </div>


            {{-- ===== PUNTO 5: Buscador rápido (solo admin) ===== --}}
            @can('admin-tramites')
            <div class="bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-5">
                    <form action="{{ route('admin.tramites.index') }}" method="GET" class="flex gap-3 items-center">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search"
                                   placeholder="Buscar por número de expediente, nombre o DNI..."
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-bold text-sm focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all placeholder:font-normal placeholder:text-slate-400">
                        </div>
                        <button type="submit"
                                class="px-5 py-3 bg-brand-900 text-white rounded-xl font-bold text-sm hover:bg-brand-800 transition-all shadow-md shadow-brand-900/20 flex items-center gap-2 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Buscar
                        </button>
                    </form>
                </div>
            </div>
            @endcan

            <!-- ===== PUNTO 3: Últimos trámites (admin = sistema, usuario = propios) ===== -->
            @if($misTramites->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                {{ $isAdmin ? 'Trámites Recientes del Sistema' : 'Mis Últimos Trámites' }}
                            </h3>
                            @if($isAdmin)
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Últimos expedientes ingresados por todos los usuarios</p>
                            @endif
                        </div>
                        <a href="{{ $isAdmin ? route('admin.tramites.index') : route('tramites.index') }}" class="text-brand-600 hover:text-brand-800 text-sm font-semibold transition-colors">
                            Ver todos →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($misTramites as $tramite)
                        <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-brand-50 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-brand-100 transition-colors">
                                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $tramite->numero_expediente }}</p>
                                    <p class="text-xs text-gray-500 font-medium">{{ $tramite->procedimientoTupa->nombre }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                    @if($tramite->estado === 'Recibido') bg-blue-100 text-blue-700
                                    @elseif($tramite->estado === 'En Revisión') bg-amber-100 text-amber-700
                                    @elseif($tramite->estado === 'Aprobado') bg-emerald-100 text-emerald-700
                                    @elseif($tramite->estado === 'Rechazado') bg-rose-100 text-rose-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ $tramite->estado }}
                                </span>
                                <a href="{{ route('tramites.show', $tramite) }}"
                                   class="p-2 text-gray-400 hover:text-brand-600 hover:bg-white rounded-full transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- ===== PUNTO 6: Panel Admin con conteos en módulos ===== --}}
            @can('admin-tramites')
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Panel de Administración</h3>
                            <p class="text-sm text-slate-500 font-medium">Acceso directo a los módulos del sistema.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Gestión de Trámites --}}
                        <a href="{{ route('admin.tramites.index') }}"
                           class="group p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:border-blue-300 hover:bg-blue-50 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-black text-blue-700">{{ $counts['total_tramites'] }}</span>
                            </div>
                            <h4 class="font-black text-slate-900 group-hover:text-blue-700 transition-colors">Gestión de Trámites</h4>
                            <p class="text-sm text-slate-500 mt-1">Expedientes totales en el sistema.</p>
                            <div class="mt-3 flex items-center gap-1 text-xs font-bold text-blue-600 group-hover:gap-2 transition-all">
                                Ver todos <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>

                        {{-- Sistema Financiero --}}
                        <a href="{{ route('finanzas.index') }}"
                           class="group p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-black text-emerald-700">{{ $counts['finanzas_pendientes'] }}</span>
                            </div>
                            <h4 class="font-black text-slate-900 group-hover:text-emerald-700 transition-colors">Sistema Financiero</h4>
                            <p class="text-sm text-slate-500 mt-1">Trámites pendientes de pago/registro.</p>
                            <div class="mt-3 flex items-center gap-1 text-xs font-bold text-emerald-600 group-hover:gap-2 transition-all">
                                Ver finanzas <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>

                        {{-- Sistema de Archivo --}}
                        <a href="{{ route('archivos.index') }}"
                           class="group p-6 bg-slate-50 border border-slate-100 rounded-2xl hover:border-purple-300 hover:bg-purple-50 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-black text-purple-700">{{ $counts['archivos'] }}</span>
                            </div>
                            <h4 class="font-black text-slate-900 group-hover:text-purple-700 transition-colors">Sistema de Archivo</h4>
                            <p class="text-sm text-slate-500 mt-1">Expedientes físicos archivados.</p>
                            <div class="mt-3 flex items-center gap-1 text-xs font-bold text-purple-600 group-hover:gap-2 transition-all">
                                Ver archivo <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endcan

            {{-- ===== PUNTO 7: Feed de actividad reciente (solo admin) ===== --}}
            @can('admin-tramites')
            @if($actividadReciente->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Actividad Reciente</h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Últimas acciones registradas en el sistema</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="En vivo"></div>
                    </div>
                    <div class="space-y-3">
                        @foreach($actividadReciente as $actividad)
                        <div class="flex items-start gap-4 group">
                            {{-- Avatar del usuario --}}
                            <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center text-xs font-black uppercase shadow-sm
                                @if($actividad->estado === 'Recibido') bg-blue-100 text-blue-700
                                @elseif($actividad->estado === 'En Revisión') bg-amber-100 text-amber-700
                                @elseif($actividad->estado === 'Aprobado') bg-emerald-100 text-emerald-700
                                @elseif($actividad->estado === 'Rechazado') bg-rose-100 text-rose-700
                                @else bg-slate-100 text-slate-600 @endif">
                                {{ substr($actividad->user?->name ?? 'S', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">
                                    <span class="text-brand-700">{{ $actividad->user?->name ?? 'Sistema' }}</span>
                                    ingresó el expediente
                                    <span class="font-black text-slate-900">{{ $actividad->numero_expediente }}</span>
                                </p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                        @if($actividad->estado === 'Recibido') bg-blue-100 text-blue-700
                                        @elseif($actividad->estado === 'En Revisión') bg-amber-100 text-amber-700
                                        @elseif($actividad->estado === 'Aprobado') bg-emerald-100 text-emerald-700
                                        @elseif($actividad->estado === 'Rechazado') bg-rose-100 text-rose-700
                                        @else bg-slate-100 text-slate-600 @endif">
                                        {{ $actividad->estado }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $actividad->created_at?->diffForHumans() }}</span>
                                </div>
                            </div>
                            <a href="{{ route('tramites.show', $actividad) }}"
                               class="flex-shrink-0 p-1.5 text-slate-300 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        @if(!$loop->last)
                        <div class="ml-4 pl-8 border-l-2 border-slate-100 h-2"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @endcan

        </div>
    </div>
</x-app-layout>
