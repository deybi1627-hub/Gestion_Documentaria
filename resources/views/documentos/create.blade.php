<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Publicar Documento - I.E.S.P.P. Victorino Elorz</title>
</head>
<body class="bg-[#f0f4f8] font-sans text-slate-900">

    <!-- Navbar Minimalista -->
    <nav class="bg-white border-b shadow-sm py-4 mb-10">
        <div class="max-w-5xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="https://www.gob.pe/images/logo-gobpe.svg" alt="Logo" class="h-8">
                <span class="text-slate-300">|</span>
                <span class="text-xs font-black uppercase text-slate-500 tracking-tighter">Panel de Gestión de Contenidos</span>
            </div>
            <a href="{{ route('documentos.index') }}" class="text-sm font-bold text-blue-900 flex items-center gap-1 hover:underline">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver al Portal
            </a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 pb-20">
        <!-- Título de la sección -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 flex items-center gap-3">
                <span class="bg-red-600 w-2 h-8 rounded-full"></span>
                Publicar nuevo informe
            </h1>
            <p class="text-slate-500 font-medium mt-2">Complete los campos para subir un documento oficial al portal institucional.</p>
        </div>

        <!-- Formulario con Tarjeta -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="bg-slate-900 p-4 flex justify-center">
                 <span class="text-white/50 text-[10px] font-black uppercase tracking-[0.2em]">Formulario Oficial de Publicación</span>
            </div>

            <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-8">
                @csrf

                <!-- Título -->
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-lg">title</span>
                        Título del informe o publicación
                    </label>
                    <input type="text" name="titulo" required placeholder="Ej. Oficio Múltiple N.° 00049-2026-MINEDU"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-slate-800 outline-none">
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Tipo de Publicación -->
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600 text-lg">category</span>
                            Tipo de publicación
                        </label>
                        <select name="tipo" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-slate-800 outline-none appearance-none">
                            <option value="Oficio">Oficio</option>
                            <option value="Resolución">Resolución</option>
                            <option value="TUPA">TUPA</option>
                            <option value="Directiva">Directiva</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <!-- Fecha de Publicación -->
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600 text-lg">calendar_today</span>
                            Fecha del documento
                        </label>
                        <input type="date" name="fecha_publicacion" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-slate-800 outline-none">
                    </div>
                </div>

                <!-- Descripción -->
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-lg">subject</span>
                        Descripción breve
                    </label>
                    <textarea name="descripcion" rows="4" placeholder="Breve descripción del contenido del informe..."
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-medium text-slate-700 outline-none resize-none"></textarea>
                </div>

                <!-- Carga de Archivo -->
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-lg">picture_as_pdf</span>
                        Archivo PDF adjunto
                    </label>
                    <div class="relative group">
                        <input type="file" name="archivo" required accept="application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full py-10 border-4 border-dashed border-slate-200 rounded-3xl flex flex-col items-center justify-center group-hover:border-blue-400 group-hover:bg-blue-50 transition-all">
                            <span class="material-symbols-outlined text-5xl text-slate-300 group-hover:text-blue-500 mb-2">upload_file</span>
                            <p class="text-slate-400 group-hover:text-blue-600 font-bold text-sm uppercase tracking-tighter">Click para seleccionar o arrastra el archivo</p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-red-200 transition-all active:scale-95 uppercase tracking-widest">
                        Publicar Documento
                    </button>
                    <a href="{{ route('documentos.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black py-5 rounded-2xl transition-all text-center uppercase tracking-widest">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>