<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Bienvenida y Accesos Rápidos -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Bienvenido, {{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-600">Sistema de Gestión Documentaria y Mesa de Partes</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ url('/') }}"
                               class="bg-slate-700 text-white px-4 py-2 rounded-md hover:bg-slate-800 text-sm">
                                Regresar al Inicio
                            </a>
                            <a href="{{ route('tramites.index') }}"
                               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                Nuevo Trámite
                            </a>
                            <a href="{{ route('seguimiento.form') }}"
                               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                                Seguimiento
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Activos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Activos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $counts['activos'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Completados</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $counts['completados'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vencidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-rose-50 rounded-lg flex items-center justify-center text-rose-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Vencidos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $counts['vencidos'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archivados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Archivados</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $counts['archivos'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Últimos Trámites -->
            @if($misTramites->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Mis Últimos Trámites</h3>
                        <a href="{{ route('tramites.index') }}" class="text-brand-600 hover:text-brand-800 text-sm font-semibold transition-colors">
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

            <!-- Acceso Rápido a Módulos (Solo para Admin/Secretario) -->
            @can('admin-tramites')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Panel de Administración</h3>
                            <p class="text-sm text-gray-500">Gestión interna y control del sistema.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('admin.tramites.index') }}"
                           class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-brand-200 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h4 class="text-md font-bold text-gray-900 group-hover:text-brand-700 transition-colors">Gestión de Trámites</h4>
                            <p class="text-sm text-gray-500 mt-1">Administrar estados y flujos de expedientes.</p>
                        </a>

                        <a href="{{ route('finanzas.index') }}"
                           class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-brand-200 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-md font-bold text-gray-900 group-hover:text-brand-700 transition-colors">Sistema Financiero</h4>
                            <p class="text-sm text-gray-500 mt-1">Control de ingresos, egresos y caja.</p>
                        </a>

                        <a href="{{ route('archivos.index') }}"
                           class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-brand-200 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                </svg>
                            </div>
                            <h4 class="text-md font-bold text-gray-900 group-hover:text-brand-700 transition-colors">Sistema de Archivo</h4>
                            <p class="text-sm text-gray-500 mt-1">Organización y retención documental.</p>
                        </a>
                    </div>
                </div>
            </div>
            @endcan

        </div>
    </div>
</x-app-layout>
