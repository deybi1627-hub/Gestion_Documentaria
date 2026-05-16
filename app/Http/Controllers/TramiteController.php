<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tramite;
use App\Models\ProcedimientoTupa;
use App\Models\TramiteMovimiento;
use App\Models\MovimientoFinanciero;
use App\Models\Documento;

class TramiteController extends Controller
{
    public function index()
    {
        $procedimientos = ProcedimientoTupa::where('activo', true)->get();
        return view('tramite', compact('procedimientos'));
    }

    public function create(Request $request)
    {
        $procedimiento = ProcedimientoTupa::findOrFail($request->procedimiento_id);
        return view('tramites.create', compact('procedimiento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedimiento_tupa_id' => 'required|exists:procedimiento_tupas,id',
            'descripcion' => 'required|string|max:1000',
            'documentos.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $procedimiento = ProcedimientoTupa::findOrFail($request->procedimiento_tupa_id);

        // Crear el trámite
        $tramite = Tramite::create([
            'user_id' => Auth::id(),
            'procedimiento_tupa_id' => $request->procedimiento_tupa_id,
            'estado' => 'Recibido',
            'descripcion' => $request->descripcion,
            'fecha_inicio' => now(),
            'fecha_limite' => $procedimiento->calcularFechaLimite(),
            'requisitos_completados' => [] // Inicialmente vacío
        ]);

        // Generar número de expediente
        $tramite->update([
            'numero_expediente' => $tramite->generarNumeroExpediente()
        ]);

        // Crear movimiento inicial
        TramiteMovimiento::create([
            'tramite_id' => $tramite->id,
            'user_id' => Auth::id(),
            'estado_anterior' => null,
            'estado_nuevo' => 'Recibido',
            'comentarios' => 'Trámite recibido en Mesa de Partes',
            'fecha_movimiento' => now()
        ]);

        // Crear movimiento financiero si hay costo
        if ($procedimiento->costo > 0) {
            MovimientoFinanciero::create([
                'tramite_id' => $tramite->id,
                'tipo' => 'ingreso',
                'categoria' => 'Derechos de trámite',
                'monto' => $procedimiento->costo,
                'descripcion' => "Pago por {$procedimiento->nombre}",
                'estado' => 'pendiente',
                'fecha_transaccion' => now()
            ]);
        }

        // Guardar documentos adjuntos
        if ($request->hasFile('documentos')) {
            foreach ($request->file('documentos') as $archivo) {
                $ruta = $archivo->store('tramites', 'public');

                Documento::create([
                    'titulo' => $archivo->getClientOriginalName(),
                    'tipo' => 'Adjunto',
                    'descripcion' => "Documento adjunto para trámite {$tramite->numero_expediente}",
                    'archivo_path' => $ruta,
                    'tramite_id' => $tramite->id,
                    'categoria' => 'tramite',
                    'fecha_publicacion' => now()
                ]);
            }
        }

        return redirect()->route('tramites.show', $tramite)
                        ->with('success', 'Trámite creado exitosamente. Número de expediente: ' . $tramite->numero_expediente);
    }

    public function show(Tramite $tramite)
    {
        $this->authorize('view', $tramite);

        $tramite->load(['user', 'procedimientoTupa', 'movimientos.user', 'documentos', 'movimientosFinancieros']);

        return view('tramites.show', compact('tramite'));
    }

    public function seguimiento(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:3'
        ]);

        $search = $request->search;

        $tramite = Tramite::where('numero_expediente', 'like', "%{$search}%")
                         ->orWhereHas('user', function($query) use ($search) {
                             $query->where('name', 'like', "%{$search}%");
                         })
                         ->first();

        if (!$tramite) {
            return back()->with('error', 'No se encontró ningún trámite con esos datos. Verifique su número de expediente o nombre.');
        }

        return view('tramites.seguimiento', compact('tramite'));
    }

    // Métodos para administradores/secretarios
    public function adminIndex(Request $request)
    {
        $query = Tramite::with(['user', 'procedimientoTupa']);

        // Filtros
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $tramites = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('tramites.admin.index', compact('tramites'));
    }

    public function cambiarEstado(Request $request, Tramite $tramite)
    {
        $request->validate([
            'estado' => 'required|in:Recibido,En Revisión,Aprobado,Rechazado,Finalizado',
            'comentarios' => 'nullable|string|max:500',
            'departamento_destino' => 'nullable|string'
        ]);

        $estadoAnterior = $tramite->estado;

        $tramite->update([
            'estado' => $request->estado,
            'fecha_finalizacion' => in_array($request->estado, ['Aprobado', 'Rechazado', 'Finalizado']) ? now() : null
        ]);

        // Crear movimiento
        TramiteMovimiento::create([
            'tramite_id' => $tramite->id,
            'user_id' => Auth::id(),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $request->estado,
            'departamento_origen' => $tramite->procedimientoTupa->departamento_responsable,
            'departamento_destino' => $request->departamento_destino,
            'comentarios' => $request->comentarios,
            'fecha_movimiento' => now()
        ]);

        return back()->with('success', 'Estado del trámite actualizado');
    }
}
