<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Sistema de Archivo') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Gestión física y organización documental.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('archivos.por-destruir') }}"
                   class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Por Destruir
                    @if($estadisticas['por_destruir'] > 0)
                        <span class="bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]">{{ $estadisticas['por_destruir'] }}</span>
                    @endif
                </a>
                <a href="{{ route('archivos.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold text-sm shadow-md shadow-blue-600/20 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                    Archivar Documento
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Búsqueda Rápida -->
            <div class="bg-brand-900 overflow-hidden shadow-sm sm:rounded-2xl border-4 border-brand-800 p-6 relative">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                </div>
                <div class="relative z-10">
                    <h3 class="text-sm font-black text-brand-200 uppercase tracking-widest mb-3">Búsqueda Física por Código</h3>
                    <form method="POST" action="{{ route('archivos.buscar') }}" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <div class="flex-1 relative">
                            <span class="absolute left-4 top-3.5 text-brand-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" name="codigo_archivo" placeholder="Ingrese código de archivo (Ej: ARCH-2026-SEC-0001)"
                                   class="w-full pl-12 pr-4 py-3 bg-brand-800/50 border-2 border-brand-700 rounded-xl text-white placeholder:text-brand-400 font-bold focus:border-brand-400 focus:ring-0 transition" required>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-xl hover:bg-blue-400 font-black shadow-lg uppercase tracking-widest transition-all">
                            Localizar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 hover:shadow-md transition-all p-6 flex items-center">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Archivados</p>
                        <p class="text-2xl font-black text-slate-900">{{ $estadisticas['total_archivados'] }}</p>
                    </div>
                </div>

                <!-- Prestados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 hover:shadow-md transition-all p-6 flex items-center">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Prestados</p>
                        <p class="text-2xl font-black text-slate-900">{{ $estadisticas['prestados'] }}</p>
                    </div>
                </div>

                <!-- Por Destruir -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 hover:shadow-md transition-all p-6 flex items-center">
                    <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Caducados</p>
                        <p class="text-2xl font-black text-slate-900">{{ $estadisticas['por_destruir'] }}</p>
                    </div>
                </div>

                <!-- Departamentos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 hover:shadow-md transition-all p-6 flex items-center">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Oficinas</p>
                        <p class="text-2xl font-black text-slate-900">{{ count($estadisticas['departamentos']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Año</label>
                            <select name="anio" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="">Todos</option>
                                @for($year = date('Y'); $year >= date('Y') - 10; $year--)
                                <option value="{{ $year }}" {{ request('anio') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Departamento</label>
                            <select name="departamento" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="">Todos</option>
                                @foreach($estadisticas['departamentos'] as $dept)
                                <option value="{{ $dept }}" {{ request('departamento') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Estado</label>
                            <select name="estado" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="">Todos</option>
                                <option value="archivado" {{ request('estado') === 'archivado' ? 'selected' : '' }}>Archivado en Sala</option>
                                <option value="prestado" {{ request('estado') === 'prestado' ? 'selected' : '' }}>Prestado / Extraído</option>
                                <option value="destruido" {{ request('estado') === 'destruido' ? 'selected' : '' }}>Destruido</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="w-full bg-brand-600 text-white px-4 py-2.5 rounded-xl hover:bg-brand-700 font-bold shadow-md shadow-brand-600/30 transition text-sm">
                                Filtrar
                            </button>
                            <a href="{{ route('archivos.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Archivos -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Código Físico</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Documento</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Año / Depto</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Estado</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($archivos as $archivo)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-brand-900">
                                    {{ $archivo->codigo_archivo }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="font-bold mb-1">{{ $archivo->documento->titulo }}</div>
                                    <div class="text-xs text-slate-400 truncate max-w-[200px]">{{ $archivo->documento->descripcion }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-bold">
                                    {{ $archivo->anio }} <span class="text-slate-300">/</span> {{ $archivo->departamento }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        @if($archivo->estado === 'archivado') bg-emerald-100 text-emerald-700
                                        @elseif($archivo->estado === 'prestado') bg-amber-100 text-amber-700
                                        @else bg-rose-100 text-rose-700 @endif">
                                        {{ $archivo->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('archivos.show', $archivo) }}" class="inline-flex items-center gap-1 text-brand-600 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-colors font-bold text-xs">
                                        Ver
                                    </a>
                                    @if($archivo->estado !== 'destruido')
                                    <a href="{{ route('archivos.edit', $archivo) }}" class="ml-1 inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-bold text-xs">
                                        Editar
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold text-lg">No hay documentos archivados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($archivos->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $archivos->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>