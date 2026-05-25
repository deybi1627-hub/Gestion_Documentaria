<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trámite: ' . $tramite->numero_expediente) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $tramite->procedimientoTupa->nombre }}</h3>
                            <p class="text-sm text-gray-600">{{ $tramite->procedimientoTupa->descripcion }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($tramite->estado === 'Recibido') bg-blue-100 text-blue-800
                            @elseif($tramite->estado === 'En Revisión') bg-yellow-100 text-yellow-800
                            @elseif($tramite->estado === 'Aprobado') bg-green-100 text-green-800
                            @elseif($tramite->estado === 'Rechazado') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $tramite->estado }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Número de Expediente:</span>
                            <span class="text-gray-900">{{ $tramite->numero_expediente }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Fecha de Inicio:</span>
                            <span class="text-gray-900">{{ $tramite->fecha_inicio->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Fecha Límite:</span>
                            <span class="text-gray-900">{{ $tramite->fecha_limite ? $tramite->fecha_limite->format('d/m/Y') : 'No definida' }}</span>
                        </div>
                        @if($tramite->fecha_finalizacion)
                        <div>
                            <span class="font-medium text-gray-700">Fecha de Finalización:</span>
                            <span class="text-gray-900">{{ $tramite->fecha_finalizacion->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-700">Solicitante:</span>
                            <span class="text-gray-900">{{ $tramite->user->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Costo:</span>
                            <span class="text-gray-900">S/ {{ number_format($tramite->procedimientoTupa->costo, 2) }}</span>
                        </div>
                    </div>

                    @if($tramite->estaVencido())
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-md p-3">
                        <div class="text-sm text-red-700">
                            ⚠️ Este trámite ha excedido la fecha límite estimada.
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Descripción del Trámite</h4>
                    <p class="text-gray-700 leading-relaxed">{{ $tramite->descripcion }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">Historial de Movimientos</h4>
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-100"></div>

                        <div class="space-y-8 relative">
                            @forelse($tramite->movimientos as $movimiento)
                            <div class="flex items-start">
                                <div class="relative flex items-center justify-center">
                                    <div class="w-8 h-8 bg-brand-50 rounded-full border-2 border-white shadow-sm flex items-center justify-center z-10">
                                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="ml-6 flex-1">
                                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:border-brand-200 transition-colors">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white text-brand-700 border border-brand-100 uppercase tracking-wider">
                                                {{ $movimiento->estado_nuevo }}
                                            </span>
                                            <span class="text-xs font-medium text-gray-500 mt-1 sm:mt-0">
                                                {{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $movimiento->comentarios }}</p>
                                        
                                        <div class="mt-3 flex items-center justify-between pt-3 border-t border-gray-200/50">
                                            @if($movimiento->departamento_destino)
                                            <div class="flex items-center text-xs text-gray-500">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span>Destino: {{ $movimiento->departamento_destino }}</span>
                                            </div>
                                            @endif
                                            <div class="flex items-center text-xs font-semibold text-gray-600 ml-auto">
                                                <div class="w-5 h-5 bg-brand-100 rounded-full flex items-center justify-center mr-1.5 text-[10px] text-brand-700 uppercase">
                                                    {{ substr($movimiento->user->name, 0, 1) }}
                                                </div>
                                                {{ $movimiento->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 text-sm">No hay movimientos registrados</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            @if($tramite->documentos->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Documentos Adjuntos</h4>
                    <div class="space-y-2">
                        @foreach($tramite->documentos as $documento)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $documento->titulo }}</p>
                                    <p class="text-xs text-gray-500">{{ $documento->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('tramites.documento.descargar', $documento->id) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium bg-blue-50 px-3 py-1 rounded-md hover:bg-blue-100 transition-colors">
                                Ver Documento
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($tramite->movimientosFinancieros->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información Financiera</h4>
                    <div class="space-y-4">
                        @foreach($tramite->movimientosFinancieros as $movimiento)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $movimiento->descripcion }}</p>
                                <p class="text-xs text-gray-500">{{ $movimiento->fecha_transaccion->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right flex flex-col items-end gap-2">
                                <p class="text-sm font-medium text-gray-900">S/ {{ number_format($movimiento->monto, 2) }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($movimiento->estado === 'pagado') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $movimiento->estado }}
                                </span>
                            </div>
                        </div>
                        
                        @if($movimiento->estado === 'pendiente' && !$movimiento->comprobante_path)
                        <div class="mt-2 p-3 bg-blue-50 rounded-md border border-blue-100">
                            <p class="text-xs text-blue-800 font-medium mb-2">Debe abonar el monto y subir su voucher para continuar con el trámite.</p>
                            <form action="{{ route('tramites.voucher', $movimiento) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                @csrf
                                <input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png" required class="block w-full text-xs text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 whitespace-nowrap shadow-sm">Subir Voucher</button>
                            </form>
                            <x-input-error :messages="$errors->get('comprobante')" class="mt-2" />
                        </div>
                        @elseif($movimiento->estado === 'pendiente' && $movimiento->comprobante_path)
                        <div class="mt-2 p-3 bg-green-50 rounded-md border border-green-100 flex justify-between items-center">
                            <p class="text-xs text-green-800 font-medium">Voucher subido. Esperando validación de caja.</p>
                            <a href="{{ route('finanzas.comprobante.descargar', $movimiento) }}" target="_blank" class="text-xs text-green-700 hover:underline font-bold bg-green-100 px-2.5 py-1 rounded-md transition-colors hover:bg-green-200">
                                Ver voucher adjunto
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>