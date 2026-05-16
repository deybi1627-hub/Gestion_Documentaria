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

        // Conteos para los estadísticos
        $counts = [
            'activos' => Tramite::whereIn('estado', ['Recibido', 'En Revisión'])->count(),
            'completados' => Tramite::whereIn('estado', ['Aprobado', 'Finalizado'])->count(),
            'vencidos' => Tramite::where('fecha_limite', '<', now())
                ->whereNotIn('estado', ['Finalizado', 'Aprobado', 'Rechazado'])
                ->count(),
            'archivos' => Archivo::count(),
        ];

        // Últimos trámites del usuario
        $misTramites = $user->tramites()
            ->with('procedimientoTupa')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('counts', 'misTramites'));
    }
}
