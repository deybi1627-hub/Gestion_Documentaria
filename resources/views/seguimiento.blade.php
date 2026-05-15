<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seguimiento de Trámites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <div class="text-center mb-8">
                    <h3 class="text-lg font-medium text-gray-900">Consulta el estado de tu trámite</h3>
                    <p class="text-sm text-gray-600 mt-2">Ingresa tu número de expediente y DNI para ver el estado actual</p>
                </div>

                <form action="{{ route('seguimiento.buscar') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="numero_expediente" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Expediente *
                        </label>
                        <input type="text" id="numero_expediente" name="numero_expediente"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ej: EXP-2026-000001"
                               required>
                    </div>

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">
                            DNI *
                        </label>
                        <input type="text" id="dni" name="dni"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ingresa tu DNI"
                               maxlength="8" pattern="[0-9]{8}"
                               required>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                            Consultar Estado
                        </button>
                    </div>
                </form>

                @if(session('error'))
                <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>