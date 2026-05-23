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

        // ===== PUNTO 3: Conteos correctos según rol =====
        if ($isAdmin) {
            $counts = [
                'activos'     => Tramite::whereIn('estado', ['Recibido', 'En Revisión'])->count(),
                'completados' => Tramite::whereIn('estado', ['Aprobado', 'Finalizado'])->count(),
                'vencidos'    => Tramite::where('fecha_limite', '<', now())
                                    ->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])
                                    ->count(),
                'archivos'    => Archivo::count(),
                // Punto 6: conteos para módulos admin
                'total_tramites' => Tramite::count(),
                'finanzas_pendientes' => Tramite::whereIn('estado', ['Recibido', 'En Revisión'])->count(),
            ];

            // ===== PUNTO 3: Admin ve los últimos tramites del SISTEMA (todos los usuarios) =====
            $misTramites = Tramite::with(['procedimientoTupa', 'user'])
                ->latest()
                ->take(8)
                ->get();

            // ===== PUNTO 7: Actividad reciente del sistema =====
            $actividadReciente = Tramite::with('user')
                ->latest()
                ->take(8)
                ->get();

        } else {
            $counts = [
                'activos'     => $user->tramites()->whereIn('estado', ['Recibido', 'En Revisión'])->count(),
                'completados' => $user->tramites()->whereIn('estado', ['Aprobado', 'Finalizado'])->count(),
                'vencidos'    => $user->tramites()->where('fecha_limite', '<', now())
                                    ->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])
                                    ->count(),
                'archivos'    => 0,
                'total_tramites' => 0,
                'finanzas_pendientes' => 0,
            ];

            // Usuarios normales ven solo sus trámites
            $misTramites = $user->tramites()
                ->with('procedimientoTupa')
                ->latest()
                ->take(5)
                ->get();

            $actividadReciente = collect();
        }

        return view('dashboard', compact('counts', 'misTramites', 'actividadReciente', 'isAdmin'));
    }
}
