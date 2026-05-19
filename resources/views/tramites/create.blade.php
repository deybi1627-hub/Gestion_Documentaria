<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mesa de Partes - Nuevo Trámite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Selección de Procedimiento TUPA -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Seleccione el tipo de trámite</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($procedimientos as $procedimiento)
                        <div class="border rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors"
                             onclick="seleccionarProcedimiento({{ $procedimiento->id }})">
                            <h4 class="font-medium text-gray-900">{{ $procedimiento->nombre }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $procedimiento->descripcion }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $procedimiento->dias_laborales }} días hábiles</span>
                                <span class="text-sm font-medium text-green-600">S/ {{ number_format($procedimiento->costo, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Formulario Dinámico -->
                <form id="tramiteForm" action="{{ route('tramites.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf

                    <div id="procedimientoInfo" class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 id="procNombre" class="font-medium text-blue-900"></h4>
                        <p id="procDescripcion" class="text-sm text-blue-700 mt-1"></p>
                        <div class="mt-2 flex justify-between">
                            <span class="text-sm text-blue-600">Tiempo estimado: <span id="procDias"></span> días hábiles</span>
                            <span class="text-sm font-medium text-blue-800">Costo: S/ <span id="procCosto"></span></span>
                        </div>
                    </div>

                    <!-- Descripción del trámite -->
                    <div class="mb-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción detallada del trámite *
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Describa detalladamente su solicitud..."
                                  required></textarea>
                    </div>

                    <!-- Requisitos del procedimiento -->
                    <div id="requisitosSection" class="mb-6 hidden">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Documentos requeridos</h4>
                        <div id="requisitosList" class="space-y-2">
                            <!-- Los requisitos se cargarán dinámicamente -->
                        </div>
                    </div>

                    <!-- Adjuntar documentos -->
                    <div class="mb-6">
                        <label for="documentos" class="block text-sm font-medium text-gray-700 mb-2">
                            Adjuntar documentos adicionales
                        </label>
                        <input type="file" id="documentos" name="documentos[]" multiple required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               accept=".pdf">
                        <p class="text-sm text-gray-500 mt-1">Requerido. Formatos permitidos: Solo PDF. Máximo 2MB por archivo.</p>
                    </div>

                    <!-- Resumen y envío -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Resumen del trámite</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Procedimiento:</strong> <span id="resumenProc"></span></p>
                            <p><strong>Tiempo estimado:</strong> <span id="resumenTiempo"></span></p>
                            <p><strong>Costo:</strong> S/ <span id="resumenCosto"></span></p>
                        </div>
                    </div>

                    <input type="hidden" id="procedimiento_tupa_id" name="procedimiento_tupa_id">

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="cancelarTramite()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Enviar Trámite
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let procedimientos = @json($procedimientos);
        let procedimientoSeleccionado = null;

        function seleccionarProcedimiento(id) {
            procedimientoSeleccionado = procedimientos.find(p => p.id === id);
            if (!procedimientoSeleccionado) return;

            // Mostrar formulario
            document.getElementById('tramiteForm').classList.remove('hidden');

            // Llenar información del procedimiento
            document.getElementById('procNombre').textContent = procedimientoSeleccionado.nombre;
            document.getElementById('procDescripcion').textContent = procedimientoSeleccionado.descripcion;
            document.getElementById('procDias').textContent = procedimientoSeleccionado.dias_laborales;
            document.getElementById('procCosto').textContent = parseFloat(procedimientoSeleccionado.costo).toFixed(2);

            // Llenar resumen
            document.getElementById('resumenProc').textContent = procedimientoSeleccionado.nombre;
            document.getElementById('resumenTiempo').textContent = procedimientoSeleccionado.dias_laborales + ' días hábiles';
            document.getElementById('resumenCosto').textContent = parseFloat(procedimientoSeleccionado.costo).toFixed(2);

            // Set hidden input
            document.getElementById('procedimiento_tupa_id').value = procedimientoSeleccionado.id;

            // Mostrar requisitos
            mostrarRequisitos(procedimientoSeleccionado.requisitos);

            // Scroll to form
            document.getElementById('tramiteForm').scrollIntoView({ behavior: 'smooth' });
        }

        function mostrarRequisitos(requisitos) {
            const container = document.getElementById('requisitosList');
            container.innerHTML = '';

            if (!requisitos || requisitos.length === 0) {
                document.getElementById('requisitosSection').classList.add('hidden');
                return;
            }

            document.getElementById('requisitosSection').classList.remove('hidden');

            requisitos.forEach(requisito => {
                const item = document.createElement('div');
                item.className = 'flex items-center space-x-2';
                item.innerHTML = `
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" disabled>
                    <span class="text-sm text-gray-700">${requisito}</span>
                `;
                container.appendChild(item);
            });
        }

        function cancelarTramite() {
            document.getElementById('tramiteForm').classList.add('hidden');
            procedimientoSeleccionado = null;
        }
    </script>
</x-app-layout>