<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Documentos por Destruir') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Listado de archivos que han superado el tiempo de retención legal (7 años).</p>
            </div>
            <div>
                <a href="{{ route('archivos.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Regresar al Archivo Central
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alerta Legal -->
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 sm:rounded-r-2xl sm:rounded-l-sm shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-rose-800">Atención: Política de Destrucción Documental</h3>
                        <div class="mt-1 text-sm text-rose-700 font-medium">
                            <p>Los documentos listados a continuación han cumplido su periodo de retención obligatorio. Una vez que apruebes su destrucción, el registro quedará marcado como 'destruido' permanentemente. Esta acción no afecta la copia digital (si existe).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Archivos -->
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800">Expedientes Caducados ({{ $archivos->count() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Código Físico</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Documento</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Fecha Archivado</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Fecha Caducidad</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Acción</th>
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
                                    {{ $archivo->fecha_archivacion->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-rose-600 font-black">
                                    {{ $archivo->fecha_destruccion->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form method="POST" action="{{ route('archivos.destruir', $archivo) }}" onsubmit="return confirm('¿Está seguro de marcar este documento físico como destruido?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 text-white bg-rose-600 hover:bg-rose-700 px-4 py-2 rounded-xl transition-colors font-bold text-xs shadow-md shadow-rose-600/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Confirmar Destrucción
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold text-lg">No hay documentos pendientes de destrucción.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
