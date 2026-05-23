<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Administración de Trámites') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">{{ __('Gestiona los expedientes ingresados al sistema.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200">
                    Ir al Portal
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-brand-900 text-white rounded-xl hover:bg-brand-800 transition font-bold text-sm shadow-md shadow-brand-900/20">
                    Ver Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.tramites.index') }}" class="grid gap-4 md:grid-cols-5 items-end">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">{{ __('Estado') }}</label>
                            <select name="estado" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="">Todos los estados</option>
                                <option value="Recibido" {{ request('estado') == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="En Revisión" {{ request('estado') == 'En Revisión' ? 'selected' : '' }}>En Revisión</option>
                                <option value="Aprobado" {{ request('estado') == 'Aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="Rechazado" {{ request('estado') == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                                <option value="Finalizado" {{ request('estado') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">{{ __('Buscar') }}</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Expediente o Nombre..." class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700 placeholder:font-normal placeholder:text-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">{{ __('Desde') }}</label>
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">{{ __('Hasta') }}</label>
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="w-full bg-brand-600 text-white px-4 py-2.5 rounded-xl hover:bg-brand-700 font-bold shadow-md shadow-brand-600/30 transition text-sm">
                                Filtrar
                            </button>
                            <a href="{{ route('admin.tramites.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition flex items-center justify-center" title="Limpiar filtros">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Trámites -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Expediente') }}</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Usuario') }}</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Procedimiento') }}</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Estado') }}</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Fecha') }}</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($tramites as $tramite)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-brand-900">{{ $tramite->numero_expediente }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($tramite->user?->name ?? 'S', 0, 1) }}
                                            </div>
                                            {{ $tramite->user?->name ?? __('Sin usuario') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-600 max-w-xs truncate" title="{{ $tramite->procedimientoTupa?->nombre }}">
                                        {{ $tramite->procedimientoTupa?->nombre ?? __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                            @if($tramite->estado === 'Recibido') bg-blue-100 text-blue-700
                                            @elseif($tramite->estado === 'En Revisión') bg-amber-100 text-amber-700
                                            @elseif($tramite->estado === 'Aprobado') bg-emerald-100 text-emerald-700
                                            @elseif($tramite->estado === 'Rechazado') bg-rose-100 text-rose-700
                                            @else bg-slate-100 text-slate-700 @endif">
                                            {{ $tramite->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-500">{{ $tramite->created_at?->format('d M, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('tramites.show', $tramite) }}" class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-colors font-bold text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Revisar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="text-slate-500 font-bold text-lg">No se encontraron trámites</p>
                                        <p class="text-slate-400 text-sm mt-1">Ajusta los filtros de búsqueda</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tramites->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $tramites->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
