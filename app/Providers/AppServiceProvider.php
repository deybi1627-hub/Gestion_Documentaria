<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Añadimos esto para el diseño de paginación
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; // Requerido para forzar el esquema HTTPS
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Forzar que Laravel use Bootstrap o Tailwind en la paginación si es necesario
        Paginator::useTailwind();

        // 2. Definir la ruta HOME dinámicamente si Laravel 11 no la encuentra en el .env
        if (!defined('HOME')) {
            define('HOME', '/');
        }

        // 3. Gate para permitir solo admin o secretario en administración de trámites
        Gate::define('admin-tramites', function (User $user) {
            return in_array($user->role, ['admin', 'secre']);
        });

        // 4. Forzar HTTPS en producción (Railway) para corregir la carga de estilos de Vite
        if (config('app.env') === 'production' || isset($_SERVER['HTTPS'])) {
            URL::forceScheme('https');
        }
    }
}