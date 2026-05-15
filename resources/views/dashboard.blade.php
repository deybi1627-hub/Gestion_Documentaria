<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Sistema de Mesa de Partes') }}
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Trámites Activos</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Tramite::whereIn('estado', ['Recibido', 'En Revisión'])->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Trámites Completados</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Tramite::whereIn('estado', ['Aprobado', 'Finalizado'])->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Trámites Vencidos</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Tramite::where('fecha_limite', '<', now())->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Documentos Archivados</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Archivo::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Últimos Trámites -->
            @if(Auth::user()->tramites->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Mis Últimos Trámites</h3>
                    <div class="space-y-4">
                        @foreach(Auth::user()->tramites->take(5) as $tramite)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $tramite->numero_expediente }}</p>
                                    <p class="text-sm text-gray-600">{{ $tramite->procedimientoTupa->nombre }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($tramite->estado === 'Recibido') bg-blue-100 text-blue-800
                                    @elseif($tramite->estado === 'En Revisión') bg-yellow-100 text-yellow-800
                                    @elseif($tramite->estado === 'Aprobado') bg-green-100 text-green-800
                                    @elseif($tramite->estado === 'Rechazado') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $tramite->estado }}
                                </span>
                                <a href="{{ route('tramites.show', $tramite) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('tramites.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Ver todos mis trámites →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Acceso Rápido a Módulos (Solo para Admin/Secretario) -->
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'secre')
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Panel de Administración</h3>
                            <p class="text-sm text-gray-500">Accede rápidamente a los módulos administrativos.</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('admin.tramites.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Trámites
                            </a>
                            <a href="{{ route('finanzas.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Finanzas
                            </a>
                            <a href="{{ route('archivos.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Archivo
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.tramites.index') }}"
                           class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-900">Gestión de Trámites</p>
                                <p class="text-xs text-blue-700">Administrar y cambiar estados</p>
                            </div>
                        </a>

                        <a href="{{ route('finanzas.index') }}"
                           class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-900">Sistema Financiero</p>
                                <p class="text-xs text-green-700">Ingresos y egresos</p>
                            </div>
                        </a>

                        <a href="{{ route('archivos.index') }}"
                           class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-purple-900">Sistema de Archivo</p>
                                <p class="text-xs text-purple-700">Archivar y consultar documentos</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
