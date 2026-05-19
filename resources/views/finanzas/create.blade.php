<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Nuevo Movimiento') }}
                </h2>
                <p class="text-sm text-slate-500 font-medium">Registra un nuevo ingreso o egreso financiero.</p>
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
                    <form method="POST" action="{{ route('finanzas.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Tipo de Movimiento -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Tipo de Movimiento</label>
                                <select name="tipo" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                    <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso (+)</option>
                                    <option value="egreso" {{ old('tipo') == 'egreso' ? 'selected' : '' }}>Egreso (-)</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Estado</label>
                                <select name="estado" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                    <option value="pagado" {{ old('estado') == 'pagado' ? 'selected' : '' }}>Pagado / Completado</option>
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Categoría y Monto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Categoría</label>
                                <input type="text" name="categoria" value="{{ old('categoria') }}" required placeholder="Ej: Pago de Constancia"
                                       class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Monto (S/)</label>
                                <input type="number" step="0.01" min="0" name="monto" value="{{ old('monto') }}" required placeholder="0.00"
                                       class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                                <x-input-error :messages="$errors->get('monto')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Fecha Transacción -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Fecha de Transacción</label>
                            <input type="date" name="fecha_transaccion" value="{{ old('fecha_transaccion', date('Y-m-d')) }}" required
                                   class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">
                            <x-input-error :messages="$errors->get('fecha_transaccion')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Descripción Detallada</label>
                            <textarea name="descripcion" rows="3" required placeholder="Describe el motivo del movimiento..."
                                      class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-slate-50 font-bold text-slate-700">{{ old('descripcion') }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <!-- Comprobante -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Comprobante Adjunto (Opcional)</label>
                            <input type="file" name="comprobante" accept=".pdf,.jpg,.jpeg,.png"
                                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2 ml-1">Formatos: PDF, JPG, PNG. Máx: 2MB.</p>
                            <x-input-error :messages="$errors->get('comprobante')" class="mt-2" />
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="bg-brand-600 text-white px-8 py-3 rounded-xl hover:bg-brand-700 font-black uppercase tracking-widest shadow-lg shadow-brand-600/30 transition-all active:scale-[0.98]">
                                Guardar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
