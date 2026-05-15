<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado del Trámite: ' . $tramite->numero_expediente) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Estado del Trámite -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $tramite->procedimientoTupa->nombre }}</h3>
                            <p class="text-sm text-gray-600">{{ $tramite->numero_expediente }}</p>
                        </div>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            @if($tramite->estado === 'Recibido') bg-blue-100 text-blue-800
                            @elseif($tramite->estado === 'En Revisión') bg-yellow-100 text-yellow-800
                            @elseif($tramite->estado === 'Aprobado') bg-green-100 text-green-800
                            @elseif($tramite->estado === 'Rechazado') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $tramite->estado }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-gray-50 p-3 rounded-md">
                            <span class="block font-medium text-gray-700">Fecha de Inicio</span>
                            <span class="text-gray-900">{{ $tramite->fecha_inicio->format('d/m/Y') }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <span class="block font-medium text-gray-700">Fecha Límite</span>
                            <span class="text-gray-900">{{ $tramite->fecha_limite ? $tramite->fecha_limite->format('d/m/Y') : 'No definida' }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <span class="block font-medium text-gray-700">Tiempo Restante</span>
                            <span class="text-gray-900">
                                @if($tramite->fecha_limite)
                                    @if($tramite->fecha_limite->isFuture())
                                        {{ $tramite->fecha_limite->diffInDays(now()) }} días
                                    @else
                                        Vencido
                                    @endif
                                @else
                                    No definido
                                @endif
                            </span>
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

            <!-- Último Movimiento -->
            @if($tramite->movimientos->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Última Actualización</h4>
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <p class="text-sm font-medium text-gray-900">
                            Estado: {{ $tramite->movimientos->first()->estado_nuevo }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $tramite->movimientos->first()->comentarios }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $tramite->movimientos->first()->fecha_movimiento->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Información de Contacto -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Información de Contacto</h4>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p><strong>Oficina responsable:</strong> {{ $tramite->procedimientoTupa->departamento_responsable }}</p>
                        <p><strong>Correo electrónico:</strong> mesa.partes@pedagogico.edu.pe</p>
                        <p><strong>Teléfono:</strong> (01) 123-4567</p>
                        <p><strong>Horario de atención:</strong> Lunes a Viernes de 8:00 AM a 4:00 PM</p>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 rounded-md">
                        <p class="text-sm text-blue-700">
                            Si necesita más información sobre su trámite, puede contactarnos por los medios indicados arriba.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('seguimiento.form') }}"
                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    ← Realizar otra consulta
                </a>
            </div>

        </div>
    </div>
</x-app-layout>