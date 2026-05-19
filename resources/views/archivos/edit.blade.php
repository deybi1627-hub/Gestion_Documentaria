<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Editar Archivo') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Actualiza el estado físico o ubicación del documento.</p>
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
                    
                    <div class="mb-8 p-4 bg-slate-50 rounded-xl border border-slate-100 grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Código Físico</span>
                            <span class="font-black text-brand-900 text-lg">{{ $archivo->codigo_archivo }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Documento Asociado</span>
                            <span class="font-bold text-slate-800 line-clamp-1" title="{{ $archivo->documento->titulo }}">
                                {{ $archivo->documento->titulo }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('archivos.update', $archivo) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Estado Físico -->
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Estado Físico</label>
                                <select name="estado" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                    <option value="archivado" {{ $archivo->estado == 'archivado' ? 'selected' : '' }}>Archivado (En Sala)</option>
                                    <option value="prestado" {{ $archivo->estado == 'prestado' ? 'selected' : '' }}>Prestado / Extraído</option>
                                    <option value="destruido" {{ $archivo->estado == 'destruido' ? 'selected' : '' }}>Destruido</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                            </div>

                            <!-- Ubicación Física -->
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Ubicación Física</label>
                                <input type="text" name="ubicacion_fisica" value="{{ old('ubicacion_fisica', $archivo->ubicacion_fisica) }}" required
                                       class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <x-input-error :messages="$errors->get('ubicacion_fisica')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Notas -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Notas de Seguimiento (Opcional)</label>
                            <textarea name="notas" rows="3" placeholder="Registra si el documento fue prestado a alguien o cambió de estante..."
                                      class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">{{ old('notas', $archivo->notas) }}</textarea>
                            <x-input-error :messages="$errors->get('notas')" class="mt-2" />
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-black uppercase tracking-widest shadow-lg shadow-blue-600/30 transition-all active:scale-[0.98]">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
