<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal') }} - Acceso</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50">
    <div class="min-h-screen flex">
        
        <!-- Lado Izquierdo (Branding / Visual) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden items-center justify-center p-12"
            style="background: linear-gradient(to bottom right, rgba(0,33,71,0.88), rgba(0,51,102,0.82), rgba(0,80,157,0.80)), url('{{ asset('img/pedagogico.jpeg') }}') center/cover no-repeat;">
            <!-- Círculos decorativos -->
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-red-600 rounded-full blur-[120px] opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-blue-400 rounded-full blur-[150px] opacity-20 translate-x-1/3 translate-y-1/3"></div>

            <div class="relative z-10 text-center flex flex-col items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Escudo" class="h-40 w-auto mb-8 drop-shadow-2xl">
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">
                    I.E.S.P.P. "Hno. Victorino Elorz"
                </h1>
                <p class="text-blue-100 text-lg font-medium max-w-md mx-auto leading-relaxed">
                    Plataforma Integral de Gestión Documentaria y Mesa de Partes Digital.
                </p>
                <div class="mt-12 flex gap-4">
                    <span class="px-4 py-2 bg-white/10 rounded-full border border-white/20 text-white text-xs font-bold uppercase tracking-widest backdrop-blur-md">Transparencia</span>
                    <span class="px-4 py-2 bg-white/10 rounded-full border border-white/20 text-white text-xs font-bold uppercase tracking-widest backdrop-blur-md">Innovación</span>
                </div>
            </div>
        </div>

        <!-- Lado Derecho (Formulario) -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 relative bg-white">
            
            <!-- Botón de regreso móvil -->
            <a href="/" class="absolute top-8 left-8 lg:hidden flex items-center gap-2 text-slate-400 hover:text-red-600 font-bold text-sm transition-colors uppercase tracking-widest">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Inicio
            </a>
            
            <!-- Botón de regreso desktop -->
            <a href="/" class="absolute top-8 right-8 hidden lg:flex items-center gap-2 text-slate-400 hover:text-red-600 font-bold text-sm transition-colors uppercase tracking-widest">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al Portal
            </a>

            <div class="w-full max-w-md">
                
                <div class="lg:hidden flex justify-center mb-8">
                    <img src="{{ asset('img/logo.png') }}" alt="Escudo" class="h-20 w-auto">
                </div>

                <!-- Slot (Aquí va el form) -->
                {{ $slot }}
                
            </div>

            <!-- Footer pequeño -->
            <div class="absolute bottom-8 text-center w-full">
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] px-4">
                    © 2026 I.E.S.P.P. "Hno. Victorino Elorz Goicoechea"
                </p>
            </div>
        </div>
        
    </div>
</body>
</html>
