<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Tramite;
use App\Models\ProcedimientoTupa;
use App\Models\TramiteMovimiento;
use App\Models\MovimientoFinanciero;
use App\Models\Documento;
use App\Mail\EstadoTramiteActualizado;

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

    /**
     * Crea un nuevo trámite. Usa DB::transaction para garantizar integridad:
     * si algo falla (subida de archivos, etc.), todo se revierte.
     */
    public function store(Request $request)
    {
        $request->validate([
            'procedimiento_tupa_id' => 'required|exists:procedimiento_tupas,id',
            'descripcion'           => 'required|string|max:1000',
            'documentos'            => 'required|array|min:1',
            'documentos.*'          => 'required|file|mimes:pdf|max:2048'
        ], [
            'documentos.required'  => 'Debe adjuntar al menos un documento (Ej. su solicitud o DNI).',
            'documentos.*.mimes'   => 'Por seguridad, los documentos deben ser estrictamente archivos PDF.',
            'documentos.*.max'     => 'Cada documento no debe superar los 2MB.'
        ]);

        $procedimiento = ProcedimientoTupa::findOrFail($request->procedimiento_tupa_id);

        // Bloque 2: Transacción — si algo falla, todo se revierte automáticamente
        $tramite = DB::transaction(function () use ($request, $procedimiento) {

            // 1. Crear el trámite con número de expediente provisional
            $tramite = Tramite::create([
                'numero_expediente'    => 'TEMP-' . time(),
                'user_id'              => Auth::id(),
                'procedimiento_tupa_id'=> $request->procedimiento_tupa_id,
                'estado'               => 'Recibido',
                'descripcion'          => $request->descripcion,
                'fecha_inicio'         => now(),
                'fecha_limite'         => $procedimiento->calcularFechaLimite(),
                'requisitos_completados' => [],
            ]);

            // 2. Asignar número de expediente definitivo
            $tramite->update([
                'numero_expediente' => $tramite->generarNumeroExpediente()
            ]);

            // 3. Registrar movimiento inicial en el historial
            TramiteMovimiento::create([
                'tramite_id'      => $tramite->id,
                'user_id'         => Auth::id(),
                'estado_anterior' => 'Inicial',
                'estado_nuevo'    => 'Recibido',
                'comentarios'     => 'Trámite recibido en Mesa de Partes',
                'fecha_movimiento'=> now(),
            ]);

            // 4. Generar deuda financiera si el procedimiento tiene costo
            if ($procedimiento->costo > 0) {
                MovimientoFinanciero::create([
                    'tramite_id'        => $tramite->id,
                    'tipo'              => 'ingreso',
                    'categoria'         => 'Derechos de trámite',
                    'monto'             => $procedimiento->costo,
                    'descripcion'       => "Pago por {$procedimiento->nombre}",
                    'estado'            => 'pendiente',
                    'fecha_transaccion' => now(),
                ]);
            }

            // 5. Bloque 1: Guardar documentos en disco PRIVADO (no público)
            foreach ($request->file('documentos') as $archivo) {
                // Disco 'local' = storage/app/ — NO accesible desde el navegador directamente
                $ruta = $archivo->store("tramites/{$tramite->id}", 'local');

                Documento::create([
                    'titulo'           => $archivo->getClientOriginalName(),
                    'tipo'             => 'Adjunto',
                    'descripcion'      => "Documento adjunto para trámite {$tramite->numero_expediente}",
                    'archivo_path'     => $ruta,
                    'tramite_id'       => $tramite->id,
                    'categoria'        => 'tramite',
                    'fecha_publicacion'=> now(),
                ]);
            }

            return $tramite;
        }); // Fin de DB::transaction

        return redirect()->route('tramites.show', $tramite)
                         ->with('success', "Trámite creado exitosamente. Número de expediente: {$tramite->numero_expediente}");
    }

    public function show(Tramite $tramite)
    {
        Gate::authorize('view', $tramite);
        $tramite->load(['user', 'procedimientoTupa', 'movimientos.user', 'documentos', 'movimientosFinancieros']);
        return view('tramites.show', compact('tramite'));
    }

    /**
     * Bloque 1: Descarga segura de documentos adjuntos a un trámite.
     * Solo el dueño del trámite o un admin pueden descargar.
     */
    public function descargarDocumento(Tramite $tramite, Documento $documento)
    {
        Gate::authorize('view', $tramite);

        // Verificar que el documento pertenece a este trámite
        if ($documento->tramite_id !== $tramite->id) {
            abort(403, 'El documento no pertenece a este trámite.');
        }

        if (!Storage::disk('local')->exists($documento->archivo_path)) {
            abort(404, 'El archivo no se encuentra disponible.');
        }

        return Storage::disk('local')->download(
            $documento->archivo_path,
            $documento->titulo
        );
    }

    /**
     * Subida de voucher de pago — también en disco privado.
     */
    public function subirVoucher(Request $request, MovimientoFinanciero $movimiento)
    {
        $request->validate([
            'comprobante' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ], [
            'comprobante.required' => 'Debe adjuntar un archivo válido como voucher.',
            'comprobante.mimes'    => 'El voucher debe ser una imagen (JPG, PNG) o un PDF.',
            'comprobante.max'      => 'El voucher no debe pesar más de 2MB.'
        ]);

        // Verificar que el movimiento pertenece a un trámite del usuario logueado
        if ($movimiento->tramite->user_id !== Auth::id()) {
            abort(403, 'No tiene permiso para modificar este registro.');
        }

        DB::transaction(function () use ($request, $movimiento) {
            // Bloque 1: guardar voucher en disco privado
            $path = $request->file('comprobante')->store(
                "comprobantes/{$movimiento->tramite_id}",
                'local'
            );

            $movimiento->update(['comprobante_path' => $path]);

            TramiteMovimiento::create([
                'tramite_id'      => $movimiento->tramite_id,
                'user_id'         => Auth::id(),
                'estado_anterior' => $movimiento->tramite->estado,
                'estado_nuevo'    => $movimiento->tramite->estado,
                'comentarios'     => 'El usuario subió comprobante de pago para: ' . $movimiento->categoria,
                'fecha_movimiento'=> now(),
            ]);
        });

        return back()->with('success', 'Voucher subido exitosamente. El área de Finanzas validará su pago a la brevedad para continuar con su trámite.');
    }

    // =========================================================
    // Métodos para administradores / secretarios
    // =========================================================

    public function adminIndex(Request $request)
    {
        $query = Tramite::with(['user', 'procedimientoTupa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numero_expediente', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

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

    /**
     * Cambia el estado del trámite y notifica al ciudadano por email.
     * Bloque 5: Mail notification.
     */
    public function cambiarEstado(Request $request, Tramite $tramite)
    {
        $request->validate([
            'estado'               => 'required|in:Recibido,En Revisión,Aprobado,Rechazado,Finalizado',
            'comentarios'          => 'nullable|string|max:500',
            'departamento_destino' => 'nullable|string',
        ]);

        $estadoAnterior = $tramite->estado;

        DB::transaction(function () use ($request, $tramite, $estadoAnterior) {
            $tramite->update([
                'estado'            => $request->estado,
                'fecha_finalizacion'=> in_array($request->estado, ['Aprobado', 'Rechazado', 'Finalizado']) ? now() : null,
            ]);

            TramiteMovimiento::create([
                'tramite_id'           => $tramite->id,
                'user_id'              => Auth::id(),
                'estado_anterior'      => $estadoAnterior,
                'estado_nuevo'         => $request->estado,
                'departamento_origen'  => $tramite->procedimientoTupa->departamento_responsable,
                'departamento_destino' => $request->departamento_destino,
                'comentarios'          => $request->comentarios,
                'fecha_movimiento'     => now(),
            ]);
        });

        // Bloque 5: Enviar email de notificación al ciudadano (en cola o de forma síncrona)
        try {
            $tramite->load('user');
            Mail::to($tramite->user->email)->queue(new EstadoTramiteActualizado($tramite, $estadoAnterior));
        } catch (\Exception $e) {
            // Si falla el email, no interrumpimos la operación; solo lo registramos
            logger()->warning("No se pudo enviar email de notificación para trámite {$tramite->numero_expediente}: " . $e->getMessage());
        }

        return back()->with('success', 'Estado del trámite actualizado y ciudadano notificado.');
    }

    /**
     * Bloque 4: API endpoint — devuelve los requisitos de un TUPA en JSON
     * para el formulario dinámico.
     */
    public function requisitosApi(ProcedimientoTupa $procedimientoTupa)
    {
        return response()->json([
            'requisitos' => $procedimientoTupa->requisitos ?? [],
            'costo'      => $procedimientoTupa->costo,
            'dias'       => $procedimientoTupa->dias_laborales,
            'departamento' => $procedimientoTupa->departamento_responsable,
        ]);
    }
}
