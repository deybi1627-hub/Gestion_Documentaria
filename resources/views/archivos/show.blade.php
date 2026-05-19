<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Detalle de Archivo') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Información física y trazabilidad del documento.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('archivos.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Regresar
                </a>
                @if($archivo->estado !== 'destruido')
                <a href="{{ route('archivos.edit', $archivo) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold text-sm shadow-md shadow-blue-600/20 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Editar Estado
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        <!-- Columna Izquierda: Datos del Archivo Físico -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Código Físico</h3>
                                <p class="text-3xl font-black text-brand-900">{{ $archivo->codigo_archivo }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Estado</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest
                                        @if($archivo->estado === 'archivado') bg-emerald-100 text-emerald-700
                                        @elseif($archivo->estado === 'prestado') bg-amber-100 text-amber-700
                                        @else bg-rose-100 text-rose-700 @endif">
                                        {{ $archivo->estado }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Año de Archivo</h3>
                                    <p class="text-lg font-bold text-slate-800">{{ $archivo->anio }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Ubicación Física / Anaquel</h3>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center gap-3">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="font-bold text-slate-700">{{ $archivo->ubicacion_fisica ?: 'No especificada' }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Fechas Clave</h3>
                                <ul class="space-y-3">
                                    <li class="flex justify-between items-center bg-slate-50 p-3 rounded-lg border border-slate-100">
                                        <span class="text-xs font-bold text-slate-500">Archivado el:</span>
                                        <span class="text-sm font-black text-slate-700">{{ $archivo->fecha_archivacion->format('d M, Y') }}</span>
                                    </li>
                                    <li class="flex justify-between items-center bg-rose-50 p-3 rounded-lg border border-rose-100">
                                        <span class="text-xs font-bold text-rose-600">Retención hasta (7 años):</span>
                                        <span class="text-sm font-black text-rose-800">{{ $archivo->fecha_destruccion->format('d M, Y') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Columna Derecha: Datos del Documento Digital -->
                        <div class="space-y-8 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <div>
                                <h3 class="text-xs font-black text-blue-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Documento Digital Asociado
                                </h3>
                                <p class="text-xl font-bold text-slate-800 mb-2">{{ $archivo->documento->titulo }}</p>
                                <p class="text-sm text-slate-500 font-medium">{{ $archivo->documento->descripcion }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Tipo Documental</span>
                                    <span class="font-bold text-slate-700">{{ $archivo->documento->tipo }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Departamento Origen</span>
                                    <span class="font-bold text-slate-700">{{ $archivo->departamento }}</span>
                                </div>
                            </div>

                            @if($archivo->documento->archivo_path)
                                <div>
                                    <a href="{{ Storage::url($archivo->documento->archivo_path) }}" target="_blank" class="block w-full text-center px-4 py-3 bg-white border-2 border-slate-200 text-slate-700 font-black uppercase tracking-widest text-xs rounded-xl hover:bg-slate-50 transition-colors">
                                        Ver Copia Digital Original
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>

                    @if($archivo->notas)
                    <div class="mt-10 pt-8 border-t border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Notas e Historial
                        </h3>
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-6">
                            <p class="text-amber-900 font-medium whitespace-pre-line">{{ $archivo->notas }}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
