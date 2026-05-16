<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts (Inter is imported in app.css) -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="sm:ml-64 min-h-screen">
            <!-- Mobile Top Bar -->
            <nav class="sticky top-0 z-30 bg-white border-b border-gray-200 sm:hidden">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <x-application-logo class="h-6 w-auto fill-current text-brand-700 mr-3" />
                        <span class="font-bold text-lg text-brand-900">AHPRA</span>
                    </div>
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-200 sticky top-0 z-20 hidden sm:block">
                    <div class="max-w-full py-4 px-8">
                        {{ $header }}
                    </div>
                </header>
                <!-- Header for mobile (below top bar) -->
                <div class="sm:hidden bg-white px-4 py-3 border-b border-gray-100">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main class="p-4 sm:p-8">
                {{ $slot }}
            </main>
        </div>

        <script>
            // Simple logic for sidebar toggle on mobile
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.querySelector('[data-drawer-toggle="sidebar"]');
                const sidebar = document.getElementById('sidebar');
                
                if (toggleBtn && sidebar) {
                    toggleBtn.addEventListener('click', () => {
                        sidebar.classList.toggle('-translate-x-full');
                    });

                    // Close sidebar when clicking outside on mobile
                    document.addEventListener('click', (e) => {
                        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                            sidebar.classList.add('-translate-x-full');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
