<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-brand-900 sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto">
      <div class="flex items-center ps-2.5 mb-8">
         <x-application-logo class="h-8 me-3 fill-current text-white" />
         <span class="self-center text-xl font-bold whitespace-nowrap text-white">AHPRA</span>
      </div>
      <ul class="space-y-2 font-medium">
         <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('dashboard') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 002 2h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 002-2V10M9 21h6"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         <!-- Botón Publicar (Estilo Natural) -->
         <li>
            <a href="{{ route('documentos.create') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('documentos.create') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
               </svg>
               <span class="ms-3">Publicar Documento</span>
            </a>
         </li>

         <li>
            <a href="{{ route('tramites.index') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('tramites.*') && !request()->routeIs('admin.*') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
               </svg>
               <span class="ms-3">Mis Trámites</span>
            </a>
         </li>

         @can('admin-tramites')
         <li class="pt-4 mt-4 border-t border-brand-800">
            <span class="px-3 text-xs font-bold text-brand-400 uppercase tracking-widest">Administración</span>
         </li>
         <li>
            <a href="{{ route('admin.tramites.index') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('admin.tramites.*') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
               </svg>
               <span class="ms-3">Gestión Trámites</span>
            </a>
         </li>
         <li>
            <a href="{{ route('finanzas.index') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('finanzas.*') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
               </svg>
               <span class="ms-3">Finanzas</span>
            </a>
         </li>
         <li>
            <a href="{{ route('archivos.index') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all {{ request()->routeIs('archivos.*') ? 'bg-brand-800 text-white' : '' }}">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
               </svg>
               <span class="ms-3">Archivo</span>
            </a>
         </li>
         @endcan

         <li class="pt-4 mt-4 border-t border-brand-800">
            <span class="px-3 text-xs font-bold text-brand-400 uppercase tracking-widest">Usuario</span>
         </li>
         <li>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-3 text-brand-100 rounded-xl hover:bg-brand-800 group transition-all">
               <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
               </svg>
               <span class="ms-3">Perfil</span>
            </a>
         </li>
         <li>
            <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit" class="flex items-center w-full p-3 text-rose-300 rounded-xl hover:bg-rose-900/30 group transition-all">
                  <svg class="w-5 h-5 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  <span class="ms-3">Cerrar Sesión</span>
               </button>
            </form>
         </li>
      </ul>
   </div>
</aside>
