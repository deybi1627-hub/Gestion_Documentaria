<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trámite: ' . $tramite->numero_expediente) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Información del Trámite -->
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

            <!-- Descripción -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Descripción del Trámite</h4>
                    <p class="text-gray-700">{{ $tramite->descripcion }}</p>
                </div>
            </div>

            <!-- Movimientos/Historial -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Historial de Movimientos</h4>
                    <div class="space-y-4">
                        @forelse($tramite->movimientos as $movimiento)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $movimiento->estado_anterior }} → {{ $movimiento->estado_nuevo }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $movimiento->comentarios }}</p>
                                    @if($movimiento->departamento_destino)
                                    <p class="text-xs text-gray-500">Enviado a: {{ $movimiento->departamento_destino }}</p>
                                    @endif
                                </div>
                                <div class="text-right text-xs text-gray-500">
                                    <p>{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</p>
                                    <p>por {{ $movimiento->user->name }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm">No hay movimientos registrados</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Documentos Adjuntos -->
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
                            <a href="{{ Storage::url($documento->archivo_path) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Información Financiera -->
            @if($tramite->movimientosFinancieros->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información Financiera</h4>
                    <div class="space-y-2">
                        @foreach($tramite->movimientosFinancieros as $movimiento)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $movimiento->descripcion }}</p>
                                <p class="text-xs text-gray-500">{{ $movimiento->fecha_transaccion->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">S/ {{ number_format($movimiento->monto, 2) }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($movimiento->estado === 'pagado') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $movimiento->estado }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>