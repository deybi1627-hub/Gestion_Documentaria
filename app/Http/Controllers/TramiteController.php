<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Tramite;
use App\Models\ProcedimientoTupa;
use App\Models\TramiteMovimiento;
use App\Models\MovimientoFinanciero;
use App\Models\Documento;

class TramiteController extends Controller
{
    public function index()
    {
        $tramites = Auth::user()->tramites()->with('procedimientoTupa')->latest()->paginate(10);
        return view('tramites.index', compact('tramites'));
    }

    public function create(Request $request)
    {
        $procedimientos = ProcedimientoTupa::where('activo', true)->get();
        return view('tramites.create', compact('procedimientos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'procedimiento_tupa_id' => 'required|exists:procedimiento_tupas,id',
            'descripcion' => 'required|string|max:1000',
            'documentos' => 'required|array|min:1',
            'documentos.*' => 'required|file|mimes:pdf|max:2048'
        ], [
            'documentos.required' => 'Debe adjuntar al menos un documento (Ej. su solicitud o DNI).',
            'documentos.*.mimes' => 'Por seguridad, los documentos deben ser estrictamente archivos PDF.',
            'documentos.*.max' => 'Cada documento no debe superar los 2MB.'
        ]);

        $procedimiento = ProcedimientoTupa::findOrFail($request->procedimiento_tupa_id);

        // Crear el trámite
        $tramite = Tramite::create([
            'numero_expediente' => 'TEMP-' . time(), // Valor temporal para pasar la restricción de NOT NULL
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
            'estado_anterior' => 'Inicial',
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
        Gate::authorize('view', $tramite);

        $tramite->load(['user', 'procedimientoTupa', 'movimientos.user', 'documentos', 'movimientosFinancieros']);

        return view('tramites.show', compact('tramite'));
    }

    public function subirVoucher(Request $request, MovimientoFinanciero $movimiento)
    {
        $request->validate([
            'comprobante' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ], [
            'comprobante.required' => 'Debe adjuntar un archivo válido como voucher.',
            'comprobante.mimes' => 'El voucher debe ser una imagen (JPG, PNG) o un PDF.',
            'comprobante.max' => 'El voucher no debe pesar más de 2MB.'
        ]);

        // Verificar que el movimiento pertenece a un trámite del usuario logueado
        if ($movimiento->tramite->user_id !== Auth::id()) {
            abort(403, 'No tiene permiso para modificar este registro.');
        }

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');
            
            $movimiento->update([
                'comprobante_path' => $path
            ]);
            
            // Opcional: Registrar un movimiento en el historial
            TramiteMovimiento::create([
                'tramite_id' => $movimiento->tramite_id,
                'user_id' => Auth::id(),
                'estado_anterior' => $movimiento->tramite->estado,
                'estado_nuevo' => $movimiento->tramite->estado,
                'comentarios' => 'El usuario ha subido su comprobante de pago para el concepto: ' . $movimiento->categoria,
                'fecha_movimiento' => now()
            ]);
        }

        return back()->with('success', 'Voucher subido exitosamente. El área de Finanzas validará su pago a la brevedad para continuar con su trámite.');
    }

    // Métodos para administradores/secretarios
    public function adminIndex(Request $request)
    {
        $query = Tramite::with(['user', 'procedimientoTupa']);

        // ===== PUNTO 5: Búsqueda rápida =====
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_expediente', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

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
