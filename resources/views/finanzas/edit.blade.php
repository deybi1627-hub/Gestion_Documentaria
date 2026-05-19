<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Editar Movimiento') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Actualiza el estado o adjunta el comprobante del movimiento.</p>
            </div>
            <div>
                <a href="{{ route('finanzas.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-bold text-sm shadow-sm border border-slate-200 gap-2">
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
                    
                    <div class="mb-8 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Categoría</span>
                                <span class="font-bold text-slate-800">{{ $movimiento->categoria }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Monto</span>
                                <span class="font-black text-slate-800 text-lg">S/ {{ number_format($movimiento->monto, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('finanzas.update', $movimiento) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Cambiar Estado</label>
                            <select name="estado" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <option value="pagado" {{ $movimiento->estado == 'pagado' ? 'selected' : '' }}>Pagado / Completado</option>
                                <option value="pendiente" {{ $movimiento->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelado" {{ $movimiento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Subir o Reemplazar Comprobante</label>
                            <input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png"
                                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2 ml-1">Formatos: PDF, JPG, PNG. Máx: 2MB.</p>
                            <x-input-error :messages="$errors->get('comprobante')" class="mt-2" />
                            
                            @if($movimiento->comprobante_path)
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl flex justify-between items-center">
                                    <span class="text-xs font-bold text-blue-700">Ya existe un comprobante adjunto.</span>
                                    <a href="{{ asset('storage/' . $movimiento->comprobante_path) }}" target="_blank" class="text-xs font-black text-blue-800 hover:underline uppercase tracking-widest">Ver actual</a>
                                </div>
                            @endif
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
