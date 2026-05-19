<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Archivar Documento Físico') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Asigna un código y ubicación física a un documento digitalizado.</p>
            </div>
            <div>
                <a href="{{ route('archivos.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Regresar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('archivos.store') }}" class="space-y-6">
                        @csrf

                        <!-- Selección de Documento -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Documento a Archivar</label>
                            <select name="documento_id" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="">Seleccione el documento...</option>
                                @foreach($documentos as $doc)
                                    <option value="{{ $doc->id }}" {{ old('documento_id') == $doc->id ? 'selected' : '' }}>
                                        [{{ $doc->tipo }}] {{ $doc->titulo }} ({{ $doc->created_at->format('Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-400 font-bold mt-2 ml-1">Solo se muestran documentos oficiales que no han sido archivados previamente.</p>
                            <x-input-error :messages="$errors->get('documento_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Departamento -->
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Departamento / Oficina</label>
                                <input type="text" name="departamento" value="{{ old('departamento') }}" required placeholder="Ej: Secretaría Académica"
                                       class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
                            </div>

                            <!-- Ubicación Física -->
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Ubicación Física</label>
                                <input type="text" name="ubicacion_fisica" value="{{ old('ubicacion_fisica') }}" required placeholder="Ej: Estante B, Gaveta 3"
                                       class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <x-input-error :messages="$errors->get('ubicacion_fisica')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Notas -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Notas de Archivamiento</label>
                            <textarea name="notas" rows="3" placeholder="Observaciones sobre el estado físico del documento..."
                                      class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">{{ old('notas') }}</textarea>
                            <x-input-error :messages="$errors->get('notas')" class="mt-2" />
                        </div>

                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-start gap-4">
                            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-bold text-blue-900">Código Autogenerado</p>
                                <p class="text-xs text-blue-700 mt-1">El sistema generará automáticamente un código serial (Ej: ARCH-2026-SEC-0001) y asignará un tiempo de retención de 7 años según las normativas.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-black uppercase tracking-widest shadow-lg shadow-blue-600/30 transition-all active:scale-[0.98]">
                                Guardar y Archivar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
