<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Detalle de Movimiento') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Información completa de la transacción financiera.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('finanzas.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Regresar
                </a>
                @if($movimiento->estado !== 'pagado')
                <a href="{{ route('finanzas.edit', $movimiento) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold text-sm shadow-md shadow-blue-600/20 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Editar
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        <!-- Detalles Principales -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Monto de Transacción</h3>
                                <p class="text-4xl font-black {{ $movimiento->tipo === 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    S/ {{ number_format($movimiento->monto, 2) }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Tipo</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest
                                        {{ $movimiento->tipo === 'ingreso' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $movimiento->tipo }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Estado</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest
                                        @if($movimiento->estado === 'pagado') bg-emerald-100 text-emerald-700
                                        @elseif($movimiento->estado === 'pendiente') bg-amber-100 text-amber-700
                                        @else bg-slate-100 text-slate-700 @endif">
                                        {{ $movimiento->estado }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Categoría</h3>
                                <p class="text-lg font-bold text-slate-800">{{ $movimiento->categoria }}</p>
                            </div>

                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Fecha de Registro</h3>
                                <p class="text-lg font-bold text-slate-800">{{ $movimiento->fecha_transaccion->format('d M, Y') }}</p>
                            </div>

                            @if($movimiento->tramite)
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                <h3 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-2">Trámite Asociado</h3>
                                <p class="font-bold text-blue-900 mb-1">{{ $movimiento->tramite->numero_expediente }}</p>
                                <a href="{{ route('tramites.show', $movimiento->tramite) }}" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                                    Ver Expediente →
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Descripción y Comprobante -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Descripción / Concepto</h3>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-slate-700 font-medium leading-relaxed">{{ $movimiento->descripcion }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Comprobante Adjunto</h3>
                                @if($movimiento->comprobante_path)
                                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 mb-4 text-center">Hay un documento digital adjunto a esta transacción.</p>
                                        <a href="{{ asset('storage/' . $movimiento->comprobante_path) }}" target="_blank" class="px-6 py-3 bg-slate-800 text-white font-black uppercase tracking-widest text-xs rounded-xl hover:bg-slate-900 transition-all shadow-md">
                                            Ver Documento
                                        </a>
                                    </div>
                                @else
                                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center bg-slate-50">
                                        <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-400 text-sm text-center">Sin comprobante físico/digital</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
