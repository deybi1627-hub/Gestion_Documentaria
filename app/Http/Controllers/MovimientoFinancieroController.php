<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\MovimientoFinanciero;

class MovimientoFinancieroController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimientoFinanciero::with(['tramite.procedimientoTupa', 'aprobador']);

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->fecha_desde) {
            $query->whereDate('fecha_transaccion', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('fecha_transaccion', '<=', $request->fecha_hasta);
        }

        $movimientos = $query->orderBy('fecha_transaccion', 'desc')->paginate(20);

        // Resumen financiero
        $resumen = [
            'total_ingresos' => MovimientoFinanciero::ingresos()->pagados()->sum('monto'),
            'total_egresos'  => MovimientoFinanciero::egresos()->pagados()->sum('monto'),
            'saldo'          => 0,
            'pendientes'     => MovimientoFinanciero::where('estado', 'pendiente')->sum('monto'),
        ];
        $resumen['saldo'] = $resumen['total_ingresos'] - $resumen['total_egresos'];

        return view('finanzas.index', compact('movimientos', 'resumen'));
    }

    public function create()
    {
        return view('finanzas.create');
    }

    /**
     * Bloque 3: Protección contra Mass Assignment.
     * Se usa $request->only([...]) en lugar de $request->all(),
     * por lo que aunque alguien inyecte 'estado=pagado' o 'aprobado_por=1',
     * estos campos serán ignorados al crear el movimiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo'              => 'required|in:ingreso,egreso',
            'categoria'         => 'required|string|max:255',
            'monto'             => 'required|numeric|min:0',
            'descripcion'       => 'required|string|max:500',
            'estado'            => 'required|in:pendiente,pagado,cancelado',
            'fecha_transaccion' => 'required|date',
            'comprobante'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Solo se permite guardar exactamente estos campos — ninguno más
        $data = $request->only([
            'tipo', 'categoria', 'monto', 'descripcion', 'estado', 'fecha_transaccion',
        ]);

        if ($request->hasFile('comprobante')) {
            // Comprobantes también en disco privado
            $data['comprobante_path'] = $request->file('comprobante')->store('comprobantes/manuales', 'local');
        }

        MovimientoFinanciero::create($data);

        return redirect()->route('finanzas.index')->with('success', 'Movimiento financiero registrado correctamente.');
    }

    public function show(MovimientoFinanciero $movimiento)
    {
        $movimiento->load(['tramite.user', 'aprobador']);
        return view('finanzas.show', compact('movimiento'));
    }

    public function edit(MovimientoFinanciero $movimiento)
    {
        return view('finanzas.edit', compact('movimiento'));
    }

    /**
     * Bloque 3: Al aprobar/rechazar un pago, se registra quién lo hizo y cuándo.
     * Solo se permite cambiar 'estado' y añadir 'notas_internas'.
     */
    public function update(Request $request, MovimientoFinanciero $movimiento)
    {
        $request->validate([
            'estado'         => 'required|in:pendiente,pagado,cancelado',
            'notas_internas' => 'nullable|string|max:500',
            'comprobante'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $movimiento) {
            $data = [
                'estado'          => $request->estado,
                'notas_internas'  => $request->notas_internas,
                // Auditoría: registra quién aprobó y cuándo
                'aprobado_por'    => Auth::id(),
                'fecha_aprobacion'=> now(),
            ];

            if ($request->hasFile('comprobante')) {
                $data['comprobante_path'] = $request->file('comprobante')->store(
                    "comprobantes/{$movimiento->tramite_id}",
                    'local'
                );
            }

            $movimiento->update($data);
        });

        return redirect()->route('finanzas.index')->with('success', 'Movimiento actualizado y auditoría registrada.');
    }

    /**
     * Descarga segura del comprobante (disco privado).
     */
    public function descargarComprobante(MovimientoFinanciero $movimiento)
    {
        if (!$movimiento->comprobante_path || !Storage::disk('local')->exists($movimiento->comprobante_path)) {
            abort(404, 'Comprobante no disponible.');
        }

        return Storage::disk('local')->download($movimiento->comprobante_path);
    }

    public function reporte(Request $request)
    {
        $fechaDesde = $request->fecha_desde ?? now()->startOfMonth();
        $fechaHasta = $request->fecha_hasta ?? now()->endOfMonth();

        $movimientos = MovimientoFinanciero::with(['tramite.user', 'aprobador'])
                                          ->whereBetween('fecha_transaccion', [$fechaDesde, $fechaHasta])
                                          ->orderBy('fecha_transaccion')
                                          ->get();

        $resumen = [
            'ingresos'   => $movimientos->where('tipo', 'ingreso')->where('estado', 'pagado')->sum('monto'),
            'egresos'    => $movimientos->where('tipo', 'egreso')->where('estado', 'pagado')->sum('monto'),
            'pendientes' => $movimientos->where('estado', 'pendiente')->sum('monto'),
            'periodo'    => \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y'),
        ];
        $resumen['saldo'] = $resumen['ingresos'] - $resumen['egresos'];

        return view('finanzas.reporte', compact('movimientos', 'resumen'));
    }
}
