<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Reporte Financiero') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Análisis detallado de movimientos por periodo.</p>
            </div>
            <div>
                <a href="{{ route('finanzas.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Regresar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filtro de Periodo -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6">
                    <form method="GET" action="{{ route('finanzas.reporte') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Fecha Inicio</label>
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde', now()->startOfMonth()->format('Y-m-d')) }}"
                                   class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Fecha Fin</label>
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta', now()->endOfMonth()->format('Y-m-d')) }}"
                                   class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                        </div>
                        <div>
                            <button type="submit" class="px-8 py-2.5 bg-brand-900 text-white rounded-xl hover:bg-brand-800 transition font-bold text-sm shadow-md shadow-brand-900/20">
                                Generar Periodo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen del Periodo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-emerald-600 text-white overflow-hidden shadow-lg shadow-emerald-600/30 sm:rounded-2xl border border-emerald-500">
                    <div class="p-6">
                        <p class="text-xs font-black text-emerald-200 uppercase tracking-widest mb-1">Ingresos Consolidados</p>
                        <p class="text-3xl font-black">S/ {{ number_format($resumen['ingresos'], 2) }}</p>
                        <p class="text-xs font-medium text-emerald-100 mt-2">Pagos completados en el periodo.</p>
                    </div>
                </div>

                <div class="bg-rose-600 text-white overflow-hidden shadow-lg shadow-rose-600/30 sm:rounded-2xl border border-rose-500">
                    <div class="p-6">
                        <p class="text-xs font-black text-rose-200 uppercase tracking-widest mb-1">Egresos Consolidados</p>
                        <p class="text-3xl font-black">S/ {{ number_format($resumen['egresos'], 2) }}</p>
                        <p class="text-xs font-medium text-rose-100 mt-2">Gastos reportados en el periodo.</p>
                    </div>
                </div>

                <div class="bg-brand-900 text-white overflow-hidden shadow-lg shadow-brand-900/30 sm:rounded-2xl border border-brand-800">
                    <div class="p-6">
                        <p class="text-xs font-black text-brand-200 uppercase tracking-widest mb-1">Flujo Neto (Caja)</p>
                        <p class="text-3xl font-black">S/ {{ number_format($resumen['saldo'], 2) }}</p>
                        <p class="text-xs font-medium text-brand-100 mt-2">Periodo: {{ $resumen['periodo'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Datos -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800">Detalle Operativo</h3>
                    <button onclick="window.print()" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-brand-600 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Imprimir Reporte
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Fecha</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Movimiento</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Estado</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Ingreso (+)</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Egreso (-)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($movimientos as $mov)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3 whitespace-nowrap text-xs font-bold text-slate-500">{{ $mov->fecha_transaccion->format('d M, Y') }}</td>
                                <td class="px-6 py-3 text-sm text-slate-700">
                                    <span class="font-bold">{{ $mov->categoria }}</span>
                                    <span class="text-slate-400 text-xs block truncate max-w-xs">{{ $mov->descripcion }}</span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="text-[10px] font-black uppercase tracking-widest {{ $mov->estado === 'pagado' ? 'text-emerald-600' : 'text-amber-500' }}">
                                        {{ $mov->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-right font-black text-emerald-600 text-sm">
                                    @if($mov->tipo === 'ingreso') S/ {{ number_format($mov->monto, 2) }} @else - @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-right font-black text-rose-600 text-sm">
                                    @if($mov->tipo === 'egreso') S/ {{ number_format($mov->monto, 2) }} @else - @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-bold">No hay movimientos en este periodo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
