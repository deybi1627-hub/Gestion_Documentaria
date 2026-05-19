<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Determinar si es administrador
        $isAdmin = in_array($user->role, ['admin', 'secre']);

        // Conteos para los estadísticos
        if ($isAdmin) {
            $counts = [
                'activos' => Tramite::whereIn('estado', ['Recibido', 'En Revisión'])->count(),
                'completados' => Tramite::whereIn('estado', ['Aprobado', 'Finalizado'])->count(),
                'vencidos' => Tramite::where('fecha_limite', '<', now())
                    ->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])
                    ->count(),
                'archivos' => Archivo::count(),
            ];
        } else {
            $counts = [
                'activos' => $user->tramites()->whereIn('estado', ['Recibido', 'En Revisión'])->count(),
                'completados' => $user->tramites()->whereIn('estado', ['Aprobado', 'Finalizado'])->count(),
                'vencidos' => $user->tramites()->where('fecha_limite', '<', now())
                    ->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])
                    ->count(),
                'archivos' => 0, // Los usuarios normales no tienen archivos físicos que contabilizar
            ];
        }

        // Últimos trámites del usuario
        $misTramites = $user->tramites()
            ->with('procedimientoTupa')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('counts', 'misTramites'));
    }
}
