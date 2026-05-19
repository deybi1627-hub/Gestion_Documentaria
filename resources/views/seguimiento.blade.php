<x-public-layout title="Seguimiento de Trámites - Victorino Elorz">

    <main class="max-w-4xl mx-auto py-20 px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-slate-800 mb-4 uppercase tracking-tighter">
                Consulta tu Expediente
            </h2>
            <p class="text-slate-500 font-medium text-lg">Realiza el seguimiento en tiempo real de tu trámite administrativo.</p>
        </div>

        <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('seguimiento.buscar') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                <div>
                    <label for="search" class="block text-xs font-black text-slate-400 uppercase mb-3 ml-1 tracking-widest text-center">
                        Ingresa tu Número de Expediente o Nombre Completo
                    </label>
                    <div class="relative max-w-2xl mx-auto">
                        <span class="material-symbols-outlined absolute left-5 top-5 text-slate-400 text-3xl">search</span>
                        <input type="text" id="search" name="search"
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-[2rem] pl-16 pr-6 py-5 font-bold text-xl text-slate-700 focus:ring-4 focus:ring-red-500 focus:border-red-500 transition-all shadow-inner"
                               placeholder="Ej: EXP-2026-001 o Juan Perez..." required>
                    </div>
                </div>

                <div class="flex justify-center pt-2">
                    <button type="submit"
                            class="px-12 bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-full shadow-2xl shadow-red-600/30 transition-all active:scale-[0.98] uppercase tracking-widest flex items-center gap-3 text-lg">
                        <span class="material-symbols-outlined">manage_search</span>
                        Buscar Trámite
                    </button>
                </div>
            </form>

            @if(session('error'))
            <div class="mt-8 bg-red-50 border border-red-100 rounded-2xl p-4 flex items-center gap-3 text-red-600 font-bold text-sm">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </div>
            @endif
        </div>

        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">schedule</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Respuesta</p>
                <p class="text-sm font-bold text-slate-700 italic">24-48 horas hábiles</p>
            </div>
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">security</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Seguridad</p>
                <p class="text-sm font-bold text-slate-700 italic">Datos encriptados</p>
            </div>
            <div class="bg-white/50 p-6 rounded-3xl border border-slate-100 text-center">
                <span class="material-symbols-outlined text-blue-900 mb-2">info</span>
                <p class="text-[10px] font-black text-slate-400 uppercase">Soporte</p>
                <p class="text-sm font-bold text-slate-700 italic">Atención personalizada</p>
            </div>
        </div>
    </main>

</x-public-layout>