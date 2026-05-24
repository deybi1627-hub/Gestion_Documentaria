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
                        <div class="tupa-card border-2 rounded-xl p-4 hover:border-blue-500 cursor-pointer transition-all duration-200 shadow-sm hover:shadow-md"
                             data-id="{{ $procedimiento->id }}"
                             onclick="seleccionarProcedimiento(
                                 {{ $procedimiento->id }},
                                 '{{ addslashes($procedimiento->nombre) }}',
                                 '{{ addslashes($procedimiento->descripcion) }}',
                                 {{ $procedimiento->dias_laborales }},
                                 {{ $procedimiento->costo }}
                             )">
                            <h4 class="font-bold text-slate-900">{{ $procedimiento->nombre }}</h4>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $procedimiento->descripcion }}</p>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ $procedimiento->dias_laborales }} días hábiles</span>
                                <span class="text-sm font-black text-emerald-700">S/ {{ number_format($procedimiento->costo, 2) }}</span>
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
                    <div id="campoGenericoDocumentos" class="mb-6">
                        <label for="documentos" class="block text-sm font-medium text-gray-700 mb-2">
                            Adjuntar documentos
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
        const apiBaseUrl = '{{ url("/api/tupa") }}';

        function seleccionarProcedimiento(id, nombre, descripcion, dias, costo) {
            // Quitar selección anterior
            document.querySelectorAll('.tupa-card').forEach(c =>
                c.classList.remove('border-blue-600', 'bg-blue-50', 'ring-2', 'ring-blue-400'));

            // Resaltar tarjeta activa
            const card = document.querySelector(`[data-id="${id}"]`);
            if (card) card.classList.add('border-blue-600', 'bg-blue-50', 'ring-2', 'ring-blue-400');

            // Llenar información del procedimiento
            document.getElementById('procNombre').textContent = nombre;
            document.getElementById('procDescripcion').textContent = descripcion;
            document.getElementById('procDias').textContent = dias;
            document.getElementById('procCosto').textContent = parseFloat(costo).toFixed(2);
            document.getElementById('resumenProc').textContent = nombre;
            document.getElementById('resumenTiempo').textContent = dias + ' días hábiles';
            document.getElementById('resumenCosto').textContent = parseFloat(costo).toFixed(2);
            document.getElementById('procedimiento_tupa_id').value = id;

            // Mostrar spinner mientras carga
            document.getElementById('requisitosSection').classList.remove('hidden');
            document.getElementById('requisitosList').innerHTML = `
                <div class="flex items-center gap-2 text-blue-600 text-sm py-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Cargando requisitos del trámite...
                </div>`;

            // Mostrar el formulario
            const form = document.getElementById('tramiteForm');
            form.classList.remove('hidden');
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Llamar al servidor para obtener los requisitos exactos de este TUPA
            fetch(`${apiBaseUrl}/${id}/requisitos`)
                .then(r => r.json())
                .then(data => mostrarRequisitos(data.requisitos))
                .catch(() => {
                    document.getElementById('requisitosList').innerHTML =
                        '<p class="text-sm text-red-600">No se pudieron cargar los requisitos. Por favor recarga la página.</p>';
                });
        }

        /**
         * Genera un campo de subida individual por cada requisito del TUPA.
         * El usuario sabe exactamente qué documento subir y etiquetado.
         */
        function mostrarRequisitos(requisitos) {
            const container = document.getElementById('requisitosList');
            const campoGenerico = document.getElementById('campoGenericoDocumentos');
            container.innerHTML = '';

            if (!requisitos || requisitos.length === 0) {
                container.innerHTML = '<p class="text-sm text-slate-500 italic">Este trámite no requiere documentos específicos adicionales. Use el campo de abajo.</p>';
                campoGenerico.classList.remove('hidden');
                return;
            }

            // Hay requisitos específicos: ocultar el campo genérico
            campoGenerico.classList.add('hidden');

            requisitos.forEach((requisito, index) => {
                const item = document.createElement('div');
                item.className = 'bg-slate-50 border border-slate-200 rounded-xl p-4';
                item.innerHTML = `
                    <label class="block text-sm font-bold text-slate-800 mb-2">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white text-xs font-black mr-2">${index + 1}</span>
                        ${requisito} <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="documentos[]" accept=".pdf"
                           class="w-full text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                           required>
                    <p class="text-xs text-slate-400 mt-1">Solo PDF &middot; Máximo 2MB</p>
                `;
                container.appendChild(item);
            });
        }

        function cancelarTramite() {
            document.getElementById('tramiteForm').classList.add('hidden');
            document.getElementById('campoGenericoDocumentos').classList.remove('hidden');
            document.querySelectorAll('.tupa-card').forEach(c =>
                c.classList.remove('border-blue-600', 'bg-blue-50', 'ring-2', 'ring-blue-400'));
        }
    </script>

</x-app-layout>